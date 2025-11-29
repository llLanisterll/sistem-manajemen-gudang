<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
            'address' => 'Kantor Pusat'
        ]);

        // 2. Buat Akun WAREHOUSE MANAGER
        User::create([
            'name' => 'Budi Manager',
            'email' => 'manager@example.com',
            'role' => 'manager',
            'password' => Hash::make('manager123'),
            'phone' => '081234567891',
            'address' => 'Gudang Utama'
        ]);

        // 3. Buat Akun STAFF GUDANG
        User::create([
            'name' => 'Siti Staff',
            'email' => 'staff@example.com',
            'role' => 'staff',
            'password' => Hash::make('staff123'),
            'phone' => '081234567892',
            'address' => 'Gudang Utama'
        ]);

        // 4. Buat Akun SUPPLIER
        User::create([
            'name' => 'PT. Supplier Jaya',
            'email' => 'supplier@example.com',
            'role' => 'supplier',
            'password' => Hash::make('supplier123'),
            'phone' => '021-55566677', // Data khusus supplier
            'address' => 'Jl. Industri No. 99, Jakarta' // Data khusus supplier
        ]);
    }
}
