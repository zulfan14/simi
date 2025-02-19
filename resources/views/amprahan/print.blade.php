<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        h1, p {
            margin-bottom: 20px;
        }
        .content {
            text-align: left;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 12px;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <div class="kop-surat">
    <!-- <img src="{{ asset('assets/img/kop.png') }}" alt="Kop Surat" style="width: 100%; max-width: 600px;"> -->

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

    <!-- Footer (Right aligned) -->
    <div class="footer">
    <div style="text-align: center; margin-top: 50px;">
        <p>Banda Aceh, {{ $amprahan->created_at->format('d F Y') }}</p>
        <p style="margin-top: 100px; font-style: italic;">({{ $amprahan->user->name }}, S.S)</p>
    </div>
</div>


</body>
</html>
