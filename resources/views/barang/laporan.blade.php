@extends('layouts.app')

@section('content')

<style>
    #table_penyusutan_stok {
        width: 100%;
        table-layout: auto;
    }

    #table_penyusutan_stok th, #table_penyusutan_stok td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: 10px;
    }

    #table_penyusutan_stok td:nth-child(3), #table_penyusutan_stok th:nth-child(3) {
        max-width: 300px;
        width: 300px;
    }

    #table_penyusutan_stok td:nth-child(5), #table_penyusutan_stok th:nth-child(5) {
        max-width: 500px;
        width: 500px;
    }
</style>

<div class="dashboard-first">
    <div class="container">
        <div class="row">
            <h1 style="margin-top: 10px;">Laporan Penyusutan Stok</h1>
            <div class="ml-auto" style="margin-top: 10px;">
            <a href="{{ route('laporan.print_penyusutan') }}" class="btn btn-danger" ><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_penyusutan_stok" class="display">
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const load_data = () => {
        $.ajax({
            url: "/laporan/data-penyusutan",
            type: "GET",
            dataType: 'JSON',
            success: function(response) {
                console.log(response);
                
                let counter = 1;

                // Fungsi untuk format angka ke dalam format Rupiah
                function formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                }

                let table = $('#table_penyusutan_stok').DataTable();
                table.clear(); // Hapus semua baris yang ada

                $.each(response.data, function(key, value) {
                    console.log();
                    
                    let hargaPerolehan = formatRupiah(value.harga_perolehan);
                    let hargaSetelahPenyusutan = formatRupiah(value.harga_setelah_penyusutan);
                    let pengurangan = formatRupiah(value.pengurangan);

                    // Menambahkan baris ke tabel
                    let barang = `
                        <tr class="barang-row" id="index_${value.id}">
                            <td>${counter++}</td>
                            <td>${value.nama_aset}</td>
                            <td>${value.tahun_perolehan}</td>
                            <td>${value.quantity}</td>
                            <td>${hargaPerolehan}</td>
                            <td>${value.tahun_sekarang}</td>
                            <td>${pengurangan}</td>
                            <td>${hargaSetelahPenyusutan}</td>
                        </tr>
                    `;
                    table.row.add($(barang)).draw(false);
                });
            }
        });
    }

    $(document).ready(function() {
        // Inisialisasi DataTable terlebih dahulu
        $('#table_penyusutan_stok').DataTable({
            paging: true
        });

        // Memuat data setelah DataTable diinisialisasi
        load_data();
    });
</script>

@endsection
