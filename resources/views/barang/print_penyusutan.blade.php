<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 0; /* Hilangkan margin halaman */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Hilangkan margin body */
            padding: 0;
        }
        .kop-surat {
            width: 100%;
            height: auto;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .kop-surat img {
            width: 100%; /* Full width tanpa batasan */
            height: auto;
            display: block; /* Hilangkan jarak default img */
        }
        .content, .footer {
            margin: 40px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 14px;
            text-align: right;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            /* margin: 20px 40px !important; Atur margin sesuai kebutuhan (atas-bawah 20px, kiri-kanan 40px) */
            padding: 0;
        }
        th, td {
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Kop Surat Full Width -->
    <div class="kop-surat">
        <img src="{{ $base64 }}" alt="Kop Surat">
    </div>

    <!-- Header, Nomor, Lampiran, Perihal -->
    <div class="content">
        <h1><strong>LAPORAN PENYUSUTAN STOK:</strong></h1>
    </div>
    
    <!-- Table Section -->
    <div class="content">
    <table>
        <thead>
            <tr>
            <th>No</th>
            <th>Nama Aset</th>
            <th>Tahun Perolehan</th>
            <th>Quantity</th>
            <th>Harga Perolehan</th>
            <th>Tahun Sekarang</th>
            <th>Pengurangan</th>
            <th>Harga Setelah Penyusutan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_penyusutan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['nama_aset'] }}</td>
                <td>{{ $item['tahun_perolehan'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['harga_perolehan'], 2) }}</td>
                <td>{{ $item['tahun_sekarang'] }}</td>
                <td>{{ number_format($item['pengurangan'], 2) }}</td>
                <td>{{ number_format($item['harga_setelah_penyusutan'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>


</body>
</html>
