@extends('layouts.app')

@include('barang.create')
@include('barang.edit')
@include('barang.show')

@section('content')

<style>
        #table_id {
            width: 100%; /* Membuat tabel menggunakan 100% lebar kontainer */
            table-layout: auto; /* Membuat lebar kolom menyesuaikan dengan konten */
        }

        #table_id th, #table_id td {
            white-space: nowrap; /* Mencegah teks membungkus dalam satu kolom */
            text-overflow: ellipsis; /* Menambahkan elipsis ketika teks terlalu panjang */
            overflow: hidden; /* Menyembunyikan teks yang melebihi batas */
        }

        /* Menyesuaikan lebar kolom tertentu */
        #table_id td:nth-child(3), #table_id th:nth-child(3) {
            max-width: 300px; /* Lebar kolom Nama */
            width: 300px;
        }

        #table_id td:nth-child(5), #table_id th:nth-child(5) {
            max-width: 500px; /* Lebar kolom Deskripsi */
            width: 500px;
        }
    </style>
<div class="dashboard-first">
<div class="container">
    <div class="row">

        <h1 style="margin-top: 10px;">Data Inventaris</h1>
        <div class="ml-auto" style="margin-top: 10px;">
            <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_barang"><i class="fa fa-plus"></i> Tambah
            Inventaris</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
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
    <!-- Datatables Jquery -->
     
    <script>
        const load_data = () => {
            $.ajax({
                url: "/barang/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let kondisi_barang = 'Baik';
                        if (value.kondisi_barang = '2') {
                            kondisi_barang = 'Rusak Ringan';
                        }else if(value.kondisi_barang = 3) {
                            kondisi_barang = 'Rusak';
                        }
                        let aset = value.is_aset = 1 ? 'Aset' : 'Bukan Aset';
                let barang = `        
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>
                    <td><img src="/storage/${value.gambar}" alt="gambar Barang" style="width: 150px"; height="150px"></td>
                    <td>${value.nama_barang}</td>
                    <td>${value.qty}</td>
                    <td>${value.deskripsi}</td>
                    <td>${value.tahun}</td>
                    <td>${value.lama_perbaikan} hari</td>
                    <td>${value.direktorat.nama}</td>
                    <td>${aset}</td>
                    <td>${value.jenis.jenis_barang}</td>
                    <td>${kondisi_barang}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_edit_barang" data-id="${value.id}" class="mb-2 btn btn-icon btn-warning btn-lg"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_barang" data-id="${value.id}" class="mb-2 btn btn-icon btn-danger btn-lg"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
                        $('#table_id').DataTable().row.add($(barang)).draw(false);
                    });
                }
            });
        }
        $(document).ready(function() {
            $('#table_id').DataTable({
                paging: true
            });

            load_data();
        });
    </script>

    <!-- Show Modal Tambah barang -->
    <script>
        $('body').on('click', '#button_tambah_barang', function() {
            $('#modal_tambah_barang').modal('show');
        });

        $('#store').click(function(e) {
            e.preventDefault();

            let gambar = $('#gambar')[0].files[0];
            let nama_barang = $('#nama_barang').val();
            let qty = $('#qty').val();
            let tahun = $('#tahun').val();
            let lama_perbaikan = $('#lama_perbaikan').val();
            let jenis_id = $('#jenis_id').val();
            let is_aset = $('#is_aset').val();
            let deskripsi = $('#deskripsi').val();
            let kondisi_barang = $('#kondisi_barang').val();
            let harga_satuan = $('#harga_satuan').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('qty', qty);
            formData.append('nama_barang', nama_barang);
            formData.append('deskripsi', deskripsi);
            formData.append('gambar', gambar);
            formData.append('tahun', tahun);
            formData.append('lama_perbaikan', lama_perbaikan);
            formData.append('is_aset', is_aset);
            formData.append('jenis_id', jenis_id);
            formData.append('kondisi_barang', kondisi_barang);
            formData.append('harga_satuan', harga_satuan);
            formData.append('_token', token);   

            $.ajax({
                url: '/barang',
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: true,
                        timer: 3000
                    });

                    load_data();
                    $('#modal_tambah_barang').modal('hide');

                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.gambar && error.responseJSON.gambar[
                            0]) {
                        $('#alert-gambar').removeClass('d-none');
                        $('#alert-gambar').addClass('d-block');

                        $('#alert-gambar').html(error.responseJSON.gambar[0]);
                    }

                    if (error.responseJSON && error.responseJSON.nama_barang && error.responseJSON
                        .nama_barang[0]) {
                        $('#alert-nama_barang').removeClass('d-none');
                        $('#alert-nama_barang').addClass('d-block');

                        $('#alert-nama_barang').html(error.responseJSON.nama_barang[0]);
                    }

                    if (error.responseJSON && error.responseJSON.stok_minimum && error.responseJSON
                        .stok_minimum[0]) {
                        $('#alert-stok_minimum').removeClass('d-none');
                        $('#alert-stok_minimum').addClass('d-block');

                        $('#alert-stok_minimum').html(error.responseJSON.stok_minimum[0]);
                    }

                    if (error.responseJSON && error.responseJSON.jenis_id && error.responseJSON
                        .jenis_id[0]) {
                        $('#alert-jenis_id').removeClass('d-none');
                        $('#alert-jenis_id').addClass('d-block');

                        $('#alert-jenis_id').html(error.responseJSON.jenis_id[0]);
                    }

                    if (error.responseJSON && error.responseJSON.satuan_id && error.responseJSON
                        .satuan_id[0]) {
                        $('#alert-satuan_id').removeClass('d-none');
                        $('#alert-satuan_id').addClass('d-block');

                        $('#alert-satuan_id').html(error.responseJSON.satuan_id[0]);
                    }

                    if (error.responseJSON && error.responseJSON.deskripsi && error.responseJSON
                        .deskripsi[0]) {
                        $('#alert-deskripsi').removeClass('d-none');
                        $('#alert-deskripsi').addClass('d-block');

                        $('#alert-deskripsi').html(error.responseJSON.deskripsi[0]);
                    }
                }
            });
        });
    </script>

    <!-- Show Detail Data Barang -->
    <script>
        $('body').on('click', '#button_detail_barang', function() {
            let barang_id = $(this).data('id');

            $.ajax({
                url: `/barang/${barang_id}/`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#barang_id').val(response.data.id);
                    $('#detail_gambar').val(null);
                    $('#detail_nama_barang').val(response.data.nama_barang);
                    $('#detail_jenis_id').val(response.data.jenis_id);
                    $('#detail_satuan_id').val(response.data.satuan_id);
                    $('#detail_stok').val(response.data.stok !== null && response.data.stok !== '' ?
                        response.data.stok : 'Stok Kosong');
                    $('#detail_stok_minimum').val(response.data.stok_minimum);
                    $('#detail_deskripsi').val(response.data.deskripsi);

                    $('#detail_gambar_preview').attr('src', '/storage/' + response.data.gambar);
                    $('#modal_detail_barang').modal('show');
                }
            });
        });
    </script>

    <!-- Edit Data Barang -->
    <script>
        // Menampilkan Form Modal Edit
        $('body').on('click', '#button_edit_barang', function() {
            let barang_id = $(this).data('id');

            $.ajax({
                url: `/barang/${barang_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#barang_id').val(response.data.id);
                    $('#edit_gambar').val(null);
                    $('#edit_nama_barang').val(response.data.nama_barang);
                    $('#edit_stok_minimum').val(response.data.stok_minimum);
                    $('#edit_jenis_id').val(response.data.jenis_id);
                    $('#edit_satuan_id').val(response.data.satuan_id);
                    $('#edit_deskripsi').val(response.data.deskripsi);
                    $('#edit_gambar_preview').attr('src', '/storage/' + response.data.gambar);

                    $('#modal_edit_barang').modal('show');
                }
            });
        });

        // Proses Update Data
        $('#update').click(function(e) {
            e.preventDefault();

            let barang_id = $('#barang_id').val();
            let gambar = $('#edit_gambar')[0].files[0];
            let nama_barang = $('#edit_nama_barang').val();
            let stok_minimum = $('#edit_stok_minimum').val();
            let deskripsi = $('#edit_deskripsi').val();
            let jenis_id = $('#edit_jenis_id').val();
            let satuan_id = $('#edit_satuan_id').val();
            let token = $("meta[name='csrf-token']").attr("content");


            // Buat objek FormData
            let formData = new FormData();
            formData.append('gambar', gambar);
            formData.append('nama_barang', nama_barang);
            formData.append('stok_minimum', stok_minimum);
            formData.append('deskripsi', deskripsi);
            formData.append('jenis_id', jenis_id);
            formData.append('satuan_id', satuan_id);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/barang/${barang_id}`,
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: true,
                        timer: 3000
                    });

                    let row = $(`#index_${response.data.id}`);
                    let rowData = row.find('td');

                    // Memperbarui data pada kolom nomor urutan (indeks 0)
                    rowData.eq(0).text(row.index() + 1);

                    // Memperbarui data pada kolom gambar (indeks 1)
                    let imageColumn = rowData.eq(1).find('img');
                    imageColumn.attr('src', `/storage/${response.data.gambar}`);

                    // Memperbarui data pada kolom kode barang (indeks 2)
                    rowData.eq(2).text(response.data.kode_barang);

                    // Memperbarui data pada kolom nama barang (indeks 3)
                    rowData.eq(3).text(response.data.nama_barang);

                    // Memperbarui data pada kolom stok (indeks 4)
                    let stok = response.data.stok != null ? response.data.stok : "Stok Kosong";
                    rowData.eq(4).text(stok);

                    $('#modal_edit_barang').modal('hide');
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.gambar && error.responseJSON.gambar[
                            0]) {
                        $('#alert-gambar').removeClass('d-none');
                        $('#alert-gambar').addClass('d-block');

                        $('#alert-gambar').html(error.responseJSON.gambar[0]);
                    }

                    if (error.responseJSON && error.responseJSON.nama_barang && error.responseJSON
                        .nama_barang[0]) {
                        $('#alert-nama_barang').removeClass('d-none');
                        $('#alert-nama_barang').addClass('d-block');

                        $('#alert-nama_barang').html(error.responseJSON.nama_barang[0]);
                    }

                    if (error.responseJSON && error.responseJSON.stok_minimum && error.responseJSON
                        .stok_minimum[0]) {
                        $('#alert-stok_minimum').removeClass('d-none');
                        $('#alert-stok_minimum').addClass('d-block');

                        $('#alert-stok_minimum').html(error.responseJSON.stok_minimum[0]);
                    }

                    if (error.responseJSON && error.responseJSON.jenis_id && error.responseJSON
                        .jenis_id[0]) {
                        $('#alert-jenis_id').removeClass('d-none');
                        $('#alert-jenis_id').addClass('d-block');

                        $('#alert-jenis_id').html(error.responseJSON.jenis_id[0]);
                    }

                    if (error.responseJSON && error.responseJSON.satuan_id && error.responseJSON
                        .satuan_id[0]) {
                        $('#alert-satuan_id').removeClass('d-none');
                        $('#alert-satuan_id').addClass('d-block');

                        $('#alert-satuan_id').html(error.responseJSON.satuan_id[0]);
                    }

                    if (error.responseJSON && error.responseJSON.deskripsi && error.responseJSON
                        .deskripsi[0]) {
                        $('#alert-deskripsi').removeClass('d-none');
                        $('#alert-deskripsi').addClass('d-block');

                        $('#alert-deskripsi').html(error.responseJSON.deskripsi[0]);
                    }
                }
            })
        })
    </script>

    <!-- Hapus Data Barang -->
    <script>
        $('body').on('click', '#button_hapus_barang', function() {
            let barang_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/barang/${barang_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: true,
                                timer: 3000
                            });

                            // Hapus data dari cache DataTables
                            $('#table_id').DataTable().clear().draw();

                            // Ambil ulang data dan gambar tabel
                            $.ajax({
                                url: "/barang/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response) {
                                    let counter = 1;
                                    $.each(response.data, function(key, value) {
                                        let stok = value.stok != null ?
                                            value.stok : "Stok Kosong";
                                        let barang = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>
                                            <td><img src="/storage/${value.gambar}" alt="gambar Barang" style="width: 150px"; height="150px"></td>
                                            <td>${value.kode_barang}</td>
                                            <td>${value.nama_barang}</td>
                                            <td>${stok}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_detail_barang" data-id="${value.id}" class="mb-2 btn btn-icon btn-success btn-lg"><i class="far fa-eye"></i> </a>
                                                <a href="javascript:void(0)" id="button_edit_barang" data-id="${value.id}" class="mb-2 btn btn-icon btn-warning btn-lg"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_barang" data-id="${value.id}" class="mb-2 btn btn-icon btn-danger btn-lg"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                        $('#table_id').DataTable().row.add(
                                            $(barang)).draw(false);
                                    });
                                }
                            });
                        }
                    })
                }
            })
        })
    </script>


    <!-- Preview Image -->
    <script>
        function previewImage() {
            preview.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

    <script>
        function previewImageEdit() {
            edit_gambar_preview.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
