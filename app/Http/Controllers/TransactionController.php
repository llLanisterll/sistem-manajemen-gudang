<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // 1. DAFTAR TRANSAKSI
    public function index(Request $request)
    {
        // Filter berdasarkan tipe & status
        $query = Transaction::with(['user', 'details']);

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(10);

        // Tentukan view berdasarkan role
        $view = Auth::user()->role === 'manager'
            ? 'dashboard.manager.transactions.index'
            : 'dashboard.staff.transactions.index';

        // Catatan: Untuk simplifikasi tutorial ini, kita pakai 1 view yang sama dulu
        // Nanti kita buat foldernya
        return view('transactions.index', compact('transactions'));
    }

    // 2. FORM BUAT TRANSAKSI (Hanya Staff)
    public function create()
    {
        $products = Product::where('current_stock', '>', 0)->get(); // Untuk barang keluar
        $allProducts = Product::all(); // Untuk barang masuk
        $suppliers = User::where('role', 'supplier')->get();

        return view('transactions.create', compact('products', 'allProducts', 'suppliers'));
    }

    // 3. SIMPAN TRANSAKSI (Logic Kompleks)
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'date' => 'required|date',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Generate Nomor Transaksi: TRX-YYYYMMDD-XXXX
            $today = date('Ymd');
            $lastTrx = Transaction::whereDate('created_at', today())->latest()->first();
            $sequence = $lastTrx ? intval(substr($lastTrx->transaction_number, -4)) + 1 : 1;
            $trxNumber = 'TRX-' . $today . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            // Buat Transaksi Header
            $transaction = Transaction::create([
                'transaction_number' => $trxNumber,
                'user_id' => Auth::id(), // Staff pembuat
                'supplier_id' => $request->type == 'in' ? $request->supplier_id : null,
                'customer_name' => $request->type == 'out' ? $request->customer_name : null,
                'type' => $request->type,
                'date' => $request->date,
                'status' => 'pending', // Default pending menunggu approval manager
                'notes' => $request->notes
            ]);

            // Simpan Detail Produk
            foreach ($request->products as $index => $productId) {
                $qty = $request->quantities[$index];

                // Jika barang keluar, cek stok dulu (Validation)
                if ($request->type == 'out') {
                    $product = Product::find($productId);
                    if ($product->current_stock < $qty) {
                        throw new \Exception("Stok tidak cukup untuk produk: " . $product->name);
                    }
                }

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $productId,
                    'quantity' => $qty
                ]);
            }

            DB::commit();
            return redirect()->route('staff.transactions.index')->with('success', 'Transaksi berhasil dibuat, menunggu verifikasi Manager.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    // 4. DETAIL TRANSAKSI
    public function show(Transaction $transaction)
    {
        $transaction->load(['details.product', 'user', 'supplier']);
        return view('transactions.show', compact('transaction'));
    }

    // 5. UPDATE STATUS (Approval Manager)
    public function updateStatus(Request $request, Transaction $transaction)
    {
        // Pastikan hanya manager
        if (Auth::user()->role !== 'manager') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:verified,approved,rejected'
        ]);

        try {
            DB::beginTransaction();

            // Cek apakah status sudah final, jika ya jangan diubah lagi
            if (in_array($transaction->status, ['verified', 'approved', 'rejected'])) {
                return back()->with('error', 'Transaksi sudah diproses sebelumnya.');
            }

            $newStatus = $request->status;

            // LOGIKA UPDATE STOK
            if ($newStatus == 'verified' && $transaction->type == 'in') {
                // Barang Masuk Disetujui -> Tambah Stok
                foreach ($transaction->details as $detail) {
                    $detail->product->increment('current_stock', $detail->quantity);
                }
            } elseif ($newStatus == 'approved' && $transaction->type == 'out') {
                // Barang Keluar Disetujui -> Kurangi Stok
                foreach ($transaction->details as $detail) {
                    $product = $detail->product;
                    // Cek lagi stok sebelum kurangi (safety)
                    if ($product->current_stock < $detail->quantity) {
                        throw new \Exception("Stok sekarang tidak cukup untuk: " . $product->name);
                    }
                    $product->decrement('current_stock', $detail->quantity);
                }
            }

            $transaction->update(['status' => $newStatus]);

            DB::commit();
            return back()->with('success', 'Status transaksi diperbarui & stok disesuaikan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

     // 6. EXPORT KE CSV/EXCEL
    public function export()
    {
        $fileName = 'transaksi_gudang_' . date('Y-m-d_H-i') . '.csv';
        $transactions = Transaction::with(['user', 'supplier', 'details.product'])->latest()->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('No. Transaksi', 'Tipe', 'Tanggal', 'Pembuat', 'Supplier/Customer', 'Status', 'Produk', 'Qty', 'Total Item');

        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $trx) {
                // Siapkan data produk dalam satu sel (digabung koma jika banyak)
                $productList = [];
                $qtyList = [];
                foreach($trx->details as $detail) {
                    $productList[] = $detail->product->name;
                    $qtyList[] = $detail->quantity;
                }

                $row['No. Transaksi']  = $trx->transaction_number;
                $row['Tipe']           = $trx->type == 'in' ? 'Masuk' : 'Keluar';
                $row['Tanggal']        = $trx->date;
                $row['Pembuat']        = $trx->user->name;
                $row['Supplier/Cust']  = $trx->type == 'in' ? ($trx->supplier->name ?? '-') : $trx->customer_name;
                $row['Status']         = $trx->status;
                $row['Produk']         = implode(' | ', $productList);
                $row['Qty']            = implode(' | ', $qtyList);
                $row['Total Item']     = $trx->details->sum('quantity');

                fputcsv($file, array(
                    $row['No. Transaksi'],
                    $row['Tipe'],
                    $row['Tanggal'],
                    $row['Pembuat'],
                    $row['Supplier/Cust'],
                    $row['Status'],
                    $row['Produk'],
                    $row['Qty'],
                    $row['Total Item']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
