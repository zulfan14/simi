<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .kop-surat img {
            width: 100%;
            height: auto;
            display: block;
        }
        .content {
            margin: 40px;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            padding: 0;
            margin: 20px 0;
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
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 14px;
            text-align: right;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <img src="{{ $base64 }}" alt="Kop Surat">
    </div>

    <!-- Header -->
    <div class="content">
        <h1><strong>LAPORAN BARANG BERDASARKAN KONDISI</strong></h1>
    </div>

    <!-- Tabel Data Barang -->
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                    <th>Tahun</th>
                    <th>Jadwal Perbaikan</th>
                    <th>Direktorat</th>
                    <th>Asset</th>
                    <th>Kategori</th>
                    <th>Kondisi</th>
                    <th>Harga Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->qty }}</td>
                    <td>{{ $barang->deskripsi }}</td>
                    <td>{{ $barang->tahun }}</td>
                    <td>{{ $barang->lama_perbaikan }}</td>
                    <td>{{ $barang->direktorat->nama }}</td>
                    <td>{{ $barang->is_aset ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $barang->jenis->jenis_barang }}</td>
                    <td>
                        @if($barang->kondisi_barang == 1)
                            <span style="background-color: green; color: white; padding: 4px 8px; border-radius: 4px;">Baik</span>
                        @elseif($barang->kondisi_barang == 2)
                            <span style="background-color: yellow; color: black; padding: 4px 8px; border-radius: 4px;">Rusak Ringan</span>
                        @elseif($barang->kondisi_barang == 3)
                            <span style="background-color: red; color: white; padding: 4px 8px; border-radius: 4px;">Rusak</span>
                        @endif
                    </td>
                    <td>{{ number_format($barang->harga_satuan, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ now() }}</p>
    </div>

</body>
</html>
