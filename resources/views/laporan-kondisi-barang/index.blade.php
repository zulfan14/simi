@extends('layouts.app')

@section('content')

<style>
    #table_id {
        width: 100%;
        table-layout: auto;
    }

    #table_id th, #table_id td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: 10px;
    }

    #table_id td:nth-child(3), #table_id th:nth-child(3) {
        max-width: 300px;
        width: 300px;
    }

    #table_id td:nth-child(5), #table_id th:nth-child(5) {
        max-width: 500px;
        width: 500px;
    }
</style>

<div class="dashboard-first">
    <div class="container">
        <div class="row">
            <h1 style="margin-top: 10px;">Data Barang Berdasarkan Kondisi</h1>
            <div class="ml-auto" style="margin-top: 10px;">
                <a href="javascript:void(0)" class="btn btn-danger" id="print-laporan-barng"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="opsi-laporan-stok">Filter Barang Berdasarkan:</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="kondisi_barang">Kondisi Barang:</label>
                                    <select class="form-control" name="kondisi_barang" id="kondisi_barang">
                                        <option value="1" selected>Baik</option>
                                        <option value="2">Rusak Ringan</option>
                                        <option value="3">Rusak</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="tahun_barang">Tahun Barang:</label>
                                    <select class="form-control" name="tahun_barang" id="tahun_barang">
                                        <option value="">Pilih Tahun</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="jenis_barang">Jenis Barang:</label>
                                    <select class="form-control" name="jenis_barang" id="jenis_barang">
                                        <option value="">Pilih Jenis Barang</option>
                                        @foreach($jenis_barang as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->jenis_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id" class="display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jumlah</th>
                                        <th>Deskripsi</th>
                                        <th>Tahun</th>
                                        <th>Jadwal</th>
                                        <th>Direktorat</th>
                                        <th>Asset</th>
                                        <th>Kategori</th>
                                        <th>Kondisi</th>
                                        <th>Harga Persatuan</th>
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
    const load_data = (selectedOption, selectedYear, selectedJenis) => {
        // Hancurkan DataTable sebelumnya jika ada
        if ($.fn.dataTable.isDataTable('#table_id')) {
            $('#table_id').DataTable().clear().destroy();
        }

        // Inisialisasi ulang DataTable setelah hancurkan yang lama
        $('#table_id').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/laporan/fetch_kondisi_barang",
                type: "GET",
                data: {
                    kondisi: selectedOption,
                    tahun: selectedYear,
                    jenis: selectedJenis
                }
            },
            language: {
                emptyTable: "Tidak ada data yang ditemukan"
            },
            columns: [
                { data: 'id' },
                { data: 'nama_barang' },
                { data: 'qty' },
                { data: 'deskripsi' },
                { data: 'tahun' },
                { data: 'lama_perbaikan' },
                { data: 'direktorat.nama' },
                { data: 'is_aset' },
                { data: 'jenis.jenis_barang' },
                {
                    data: 'kondisi_barang',
                    render: function(data, type, row) {
                        // Memeriksa kondisi dan memberikan kelas warna yang sesuai
                        let kondisiText = '';
                        let colorClass = '';

                        if (data == 1) { // Baik
                            kondisiText = 'Baik';
                            colorClass = 'bg-success'; // Hijau
                        } else if (data == 2) { // Rusak Ringan
                            kondisiText = 'Rusak Ringan';
                            colorClass = 'bg-warning'; // Kuning
                        } else if (data == 3) { // Rusak
                            kondisiText = 'Rusak';
                            colorClass = 'bg-danger'; // Merah
                        }

                        // Mengembalikan HTML dengan warna berdasarkan kondisi
                        return `<span class="badge ${colorClass}">${kondisiText}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <a href="/barang/detail/${row.id}" target="_blank" class="mb-2 btn btn-icon btn-info btn-lg">
                                <i class="fas fa-eye"></i>
                            </a>
                        `;
                    }
                }
            ]

        });
    }

    $(document).ready(function() {
        var selectedOption = $('#kondisi_barang').val();
        var selectedYear = $('#tahun_barang').val();
        var selectedJenis = $('#jenis_barang').val();

        // Panggil load_data dengan filter yang dipilih
        load_data(selectedOption, selectedYear, selectedJenis);

        // Event ketika filter kondisi barang berubah
        $('#kondisi_barang').on('change', function() {
            selectedOption = $(this).val();
            load_data(selectedOption, selectedYear, selectedJenis);
        });

        // Event ketika input tahun barang berubah
        $('#tahun_barang').on('change', function() {
            selectedYear = $(this).val();
            load_data(selectedOption, selectedYear, selectedJenis);
        });

        // Event ketika jenis barang berubah
        $('#jenis_barang').on('change', function() {
            selectedJenis = $(this).val();
            load_data(selectedOption, selectedYear, selectedJenis);
        });

        handlePrint();
    });

    const handlePrint = () => {
        $('#print-laporan-barng').on('click', function() {
        // Ambil filter yang ada (misalnya kondisi, tahun, jenis) jika ada
        var kondisi = $('#kondisi_barang').val() ?? 0;  // Filter kondisi barang
        var tahun = $('#tahun_barang').val() ?? 0;      // Filter tahun
        var jenis = $('#jenis_barang').val() ?? 0;      // Filter jenis barang

        // Arahkan ke URL untuk menghasilkan PDF
        var url = '{{ route("laporan.print_barang") }}' + 
                  '?kondisi=' + kondisi + 
                  '&tahun=' + tahun + 
                  '&jenis=' + jenis;

        window.location.href = url; // Redirect ke URL untuk cetak PDF
    });
    }
</script>

@endsection
