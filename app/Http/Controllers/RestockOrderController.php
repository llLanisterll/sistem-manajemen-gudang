<?php

namespace App\Http\Controllers;

use App\Models\RestockOrder;
use App\Models\RestockOrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestockOrderController extends Controller
{
    // 1. LIST PESANAN RESTOCK
    public function index()
    {
        $user = Auth::user();

        // Jika Manager: Lihat semua pesanan yang dia buat
        if ($user->role === 'manager') {
            $orders = RestockOrder::with('supplier')->latest()->paginate(10);
        }
        // Jika Supplier: Hanya lihat pesanan yang ditujukan ke dia
        elseif ($user->role === 'supplier') {
            $orders = RestockOrder::where('supplier_id', $user->id)
                        ->with('manager')
                        ->latest()
                        ->paginate(10);
        } else {
            abort(403);
        }

        return view('restock.index', compact('orders'));
    }

    // 2. FORM BUAT PESANAN (Hanya Manager)
    public function create()
    {
        if (Auth::user()->role !== 'manager') abort(403);

        $suppliers = User::where('role', 'supplier')->get();
        $products = Product::all();

        return view('restock.create', compact('suppliers', 'products'));
    }

    // 3. SIMPAN PESANAN
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:users,id',
            'expected_delivery_date' => 'nullable|date',
            'products' => 'required|array',
            'quantities' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            // Generate PO Number: PO-YYYYMMDD-XXXX
            $today = date('Ymd');
            $lastPo = RestockOrder::whereDate('created_at', today())->latest()->first();
            $sequence = $lastPo ? intval(substr($lastPo->po_number, -4)) + 1 : 1;
            $poNumber = 'PO-' . $today . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            $order = RestockOrder::create([
                'po_number' => $poNumber,
                'user_id' => Auth::id(), // Manager
                'supplier_id' => $request->supplier_id,
                'expected_delivery_date' => $request->expected_delivery_date,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            foreach ($request->products as $index => $productId) {
                RestockOrderDetail::create([
                    'restock_order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $request->quantities[$index],
                ]);
            }

            DB::commit();
            return redirect()->route('manager.restock.index')->with('success', 'Restock Order berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membuat PO: ' . $e->getMessage());
        }
    }

    // 4. DETAIL PESANAN
    public function show($id) // Ganti parameter dari (RestockOrder $restockOrder) menjadi ($id)
    {
        // Ambil data manual berdasarkan ID agar tidak error binding
        $restockOrder = RestockOrder::findOrFail($id);

        // Pastikan user berhak melihat (Supplier yg bersangkutan / Manager)
        $user = Auth::user();
        if ($user->role === 'supplier' && $restockOrder->supplier_id !== $user->id) {
            abort(403);
        }

        // Load relasi data
        $restockOrder->load(['details.product', 'manager', 'supplier']);

        return view('restock.show', compact('restockOrder'));
    }

    // 5. UPDATE STATUS (Flow Supply Chain)
    public function updateStatus(Request $request, RestockOrder $restockOrder)
    {
        $request->validate(['status' => 'required']);
        $newStatus = $request->status;
        $role = Auth::user()->role;

        // Validasi Hak Akses Perubahan Status
        if ($role === 'supplier') {
            // Supplier hanya boleh Confirm / Reject
            if (!in_array($newStatus, ['confirmed', 'rejected'])) abort(403);
        }
        elseif ($role === 'manager') {
            // Manager update progress pengiriman
            if (!in_array($newStatus, ['in_transit', 'received'])) abort(403);
        }

        $restockOrder->update(['status' => $newStatus]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // 6. BERI RATING (Manager Only)
    public function rate(Request $request, $id)
    {
        $order = RestockOrder::findOrFail($id);

        if (Auth::user()->role !== 'manager') abort(403);
        if ($order->status !== 'received') return back()->with('error', 'Hanya bisa rating jika barang sudah diterima.');

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $order->update(['rating' => $request->rating]);

        return back()->with('success', 'Rating berhasil dikirim!');
    }
}
