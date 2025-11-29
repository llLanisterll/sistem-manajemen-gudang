<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Label - {{ $product->name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .label-container {
            border: 2px dashed #333;
            display: inline-block;
            padding: 20px;
            border-radius: 10px;
        }
        h2 { margin: 10px 0 5px; font-size: 18px; }
        p { margin: 0; font-size: 14px; color: #555; }
        .sku { font-weight: bold; font-size: 20px; margin-top: 10px; display: block; letter-spacing: 2px; }

        /* Hilangkan elemen lain saat print */
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
            .label-container { border: 2px solid #000; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 30px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; background: blue; color: white; border: none; cursor: pointer; border-radius: 5px;">
            🖨️ Cetak Label Sekarang
        </button>
        <br><br>
        <a href="{{ route('admin.products.index') }}" style="color: blue;">&larr; Kembali ke Daftar Produk</a>
    </div>

    <div class="label-container">
        {{-- Menampilkan QR Code SVG --}}
        <div style="margin-bottom: 10px;">
            {!! $qrcode !!}
        </div>

        <h2>{{ $product->name }}</h2>
        <p>Kategori: {{ $product->category->name }}</p>
        <span class="sku">{{ $product->sku }}</span>
    </div>

</body>
</html>
