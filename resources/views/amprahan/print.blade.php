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
        <p><strong>Nomor:</strong> {{$amprahan->nama_barang}}</p>
        <p><strong>Lampiran:</strong> {{$amprahan->lampiran}}</p>
        <p><strong>Perihal:</strong> {{$amprahan->perihal}}</p>
    </div>
    
    <!-- Address Section -->
    <div class="content">
        <p>Kepada Yang Terhormat,</p>
        <p>Rektor Universitas Ubudiyah Indonesia</p>
        <p>Di tempat</p>
    </div>

    <!-- Greeting and Body -->
    <div class="content">
        <p>Assalaamu'alaikum Wr. Wb.</p>
        <p>{{$amprahan->isi}}</p>
    </div>
    
    <!-- Table Section -->
    <div class="content">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $amprahan->nama_barang }}</td>
                <td>{{ $amprahan->harga_barang }}</td>
            </tr>
        </tbody>
    </table>
    </div>

    <!-- Footer (Right aligned) -->
    <div class="footer">
        <div style="text-align: center; margin-top: 50px;">
            <p>Banda Aceh, {{ $amprahan->created_at->format('d F Y') }}</p>
            <p style="margin-top: 100px; font-style: italic;">({{ $amprahan->user->name }})</p>
        </div>
    </div>

</body>
</html>
