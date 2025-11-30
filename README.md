# GudangPro - Sistem Manajemen Gudang (WMS)

![GudangPro Dashboard Preview](https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2670&auto=format&fit=crop)

**GudangPro** adalah aplikasi web berbasis Laravel yang dirancang untuk mendigitalisasi operasional gudang. Sistem ini mengelola inventori, memantau transaksi stok secara *real-time*, dan memfasilitasi komunikasi antara Gudang dan Supplier melalui portal terintegrasi.

## 🚀 Fitur Utama

### 🔐 Multi-User Role & Authentication
Sistem memfasilitasi 4 peran pengguna dengan hak akses spesifik:
- **Admin**: Akses penuh ke seluruh sistem, manajemen pengguna (termasuk approval supplier baru), master data produk/kategori, dan laporan.
- **Warehouse Manager**: Memantau stok, menyetujui/menolak transaksi staf, membuat Purchase Order (PO) ke supplier, dan memberikan rating kinerja supplier.
- **Staff Gudang**: Mencatat transaksi harian (barang masuk/keluar) dan memantau pergerakan stok.
- **Supplier**: Portal khusus untuk melihat pesanan (PO) yang masuk, melakukan konfirmasi, dan menolak pesanan.

### 📦 Manajemen Inventori (CMS)
- **Produk**: CRUD lengkap dengan gambar, SKU unik, harga beli/jual, stok minimum (alert), dan lokasi rak.
- **Kategori**: Pengelompokan produk dengan gambar thumbnail.
- **QR Code**: Generate otomatis QR Code untuk setiap produk (berbasis SKU) yang dapat dicetak untuk pelabelan fisik.

### 🔄 Transaksi Gudang & Supply Chain
- **Barang Masuk (Inbound)**: Pencatatan penerimaan barang dari supplier. Stok bertambah otomatis setelah diverifikasi Manager.
- **Barang Keluar (Outbound)**: Pencatatan pengiriman ke customer. Stok berkurang otomatis setelah disetujui Manager.
- **Restock Order (PO)**: Alur pengadaan barang lengkap:
  1. Manager buat PO ➝ Status *Pending*.
  2. Supplier terima notifikasi ➝ Klik *Confirm* (Status *Confirmed*).
  3. Barang dikirim ➝ Status *In Transit*.
  4. Barang diterima ➝ Status *Received*.
  5. Manager memberi **Rating Bintang (1-5)** kepada Supplier.

### 📊 Dashboard & Laporan
- **Statistik Real-time**: Widget informasi total stok, peringatan stok menipis (Low Stock Alert), dan transaksi pending.
- **Export Excel/CSV**: Fitur unduh laporan transaksi untuk rekapitulasi dan audit.
- **Filter Data**: Tab navigasi untuk memisahkan data barang masuk dan keluar dengan mudah.

## 🛠️ Teknologi yang Digunakan
- **Framework**: [Laravel 11](https://laravel.com)
- **Database**: MySQL / MariaDB
- **Frontend**: Blade Templates + [Tailwind CSS](https://tailwindcss.com)
- **Authentication**: Laravel Breeze
- **QR Code**: `simplesoftwareio/simple-qrcode`
- **Icons**: Heroicons (SVG)

## ⚙️ Instalasi & Penggunaan

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### 1. Prasyarat
Pastikan Anda sudah menginstall:
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database Server (MySQL/MariaDB)

### 2. Clone Repositori
```bash
git clone [https://github.com/llLanisterll/sistem-manajemen-gudang.git](https://github.com/llLanisterll/sistem-manajemen-gudang.git)
cd gudang-pro
