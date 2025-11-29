<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\RestockOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $data = [];

        if ($role === 'admin') {
            $data = [
                'total_users' => User::count(),
                'total_products' => Product::count(),
                'total_categories' => Category::count(),
                'recent_products' => Product::latest()->take(5)->get(),
            ];
        }
        elseif ($role === 'manager') {
            $data = [
                'total_products' => Product::count(),
                'total_stock' => Product::sum('current_stock'), // Total semua item
                'low_stock_count' => Product::whereColumn('current_stock', '<=', 'min_stock')->count(),
                'pending_transactions' => Transaction::where('status', 'pending')->count(),
                'pending_restocks' => RestockOrder::where('status', 'pending')->count(),
                'low_stock_items' => Product::whereColumn('current_stock', '<=', 'min_stock')->take(5)->get(),
            ];
        }
        elseif ($role === 'staff') {
            $userId = Auth::id();
            $data = [
                'my_transactions_today' => Transaction::where('user_id', $userId)
                                            ->whereDate('created_at', today())
                                            ->count(),
                'my_total_transactions' => Transaction::where('user_id', $userId)->count(),
                'recent_transactions' => Transaction::where('user_id', $userId)->latest()->take(5)->get(),
            ];
        }
        elseif ($role === 'supplier') {
            $userId = Auth::id();
            $data = [
                'new_orders' => RestockOrder::where('supplier_id', $userId)->where('status', 'pending')->count(),
                'in_progress' => RestockOrder::where('supplier_id', $userId)->whereIn('status', ['confirmed', 'in_transit'])->count(),
                'completed' => RestockOrder::where('supplier_id', $userId)->where('status', 'received')->count(),
                'recent_orders' => RestockOrder::where('supplier_id', $userId)->latest()->take(5)->get(),
            ];
        }

        return view('dashboard', compact('role', 'data'));
    }
    // List User (Khusus Admin)
    public function usersIndex()
    {
        // Ambil supplier yang belum aktif
        $pendingSuppliers = User::where('role', 'supplier')->where('is_active', false)->get();
        return view('admin.users.index', compact('pendingSuppliers'));
    }

    // Action Approve
    public function approveUser($id)
    {
        User::where('id', $id)->update(['is_active' => true]);
        return back()->with('success', 'Supplier berhasil disetujui!');
    }

    // Tampilkan daftar supplier pending
public function pendingSuppliers()
{
    $pendingSuppliers = User::where('role', 'supplier')
                            ->where('is_active', false)
                            ->latest()
                            ->get();

    return view('admin.users.pending', compact('pendingSuppliers'));
}

// Setujui Supplier
public function approveSupplier($id)
{
    $user = User::findOrFail($id);
    $user->update(['is_active' => true]);

    return back()->with('success', 'Supplier ' . $user->name . ' berhasil disetujui dan sekarang bisa login.');
}

// Tolak Supplier (Hapus Akun)
public function rejectSupplier($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return back()->with('success', 'Permintaan supplier ditolak dan dihapus.');
}
}
