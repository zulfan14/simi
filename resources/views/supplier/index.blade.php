@extends('layouts.app')

@include('supplier.create')
@include('supplier.edit')

@section('content')
<div class="dashboard-first">
<div class="container">
    <div class="row">
        <h1 style="margin-top: 10px !important;">Data Direktorat</h1>
        <div class="ml-auto" style="margin-top: 10px !important;">
            <a href="javascript:void(0)" class="btn btn-primary" id="btn_tambah_direktorat"><i class="fa fa-plus"></i>
                Direktorat</a>
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
                                    <th>Nama Direktorat</th>
                                    <th>Lokasi</th>
                                    <th>Opsi</th>
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

    const load_datatable = () => {
        $.ajax({
            url: '/direktorat/get-data',
            type: "GET",
            cache: false,
            success: function(response) {
                $('#table-barangs').html('');

                let counter = 1;
                $('#table_id').DataTable().clear();
                $.each(response.data, function(key, value) {
                    let direktorat = `
                    <tr class="barang-row" id="index_${value.id}">
                        <td>${counter++}</td>   
                        <td>${value.nama}</td>
                        <td>${value.lokasi}</td>
                        <td>
                            <a href="javascript:void(0)" id="button_edit_direktorat" data-id="${value.id}" class="mb-2 btn btn-icon btn-warning btn-lg"><i class="far fa-edit"></i> </a>
                            <a href="javascript:void(0)" id="button_hapus_direktorat" data-id="${value.id}" class="mb-2 btn btn-icon btn-danger btn-lg"><i class="fas fa-trash"></i> </a>
                        </td>
                    </tr>
                    `;
                    $('#table_id').DataTable().row.add($(direktorat))
                        .draw(false);
                });

                $('#direktorat').val('');
                $('#direktorat').val('');
                $('#modal_tambah_direktorat').modal('hide');

                let table = $('#table_id').DataTable();
                table.draw(); // memperbarui Datatables
            },
            error: function(error) {
                console.log(error);
            }
        })   
    }
 
        $(document).ready(function() {
            $('#table_id').DataTable();

            $.ajax({
                url: "/direktorat/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    if ($.fn.DataTable.isDataTable('#table_id')) {
                        $('#table_id').DataTable().destroy();
                    }

                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let direktorat = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.nama}</td>
                    <td>${value.lokasi}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_edit_direktorat" data-id="${value.id}" class="mb-2 btn btn-icon btn-warning btn-lg"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_direktorat" data-id="${value.id}" class="mb-2 btn btn-icon btn-danger btn-lg"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
                        $('#table_id').DataTable().row.add($(direktorat)).draw(false);
                    });
                }
            });
        });
    </script>

    <!-- Show Modal Tambah Jenis Barang -->
    <script>
        $('body').on('click', '#btn_tambah_direktorat', function() {
            $('#modal_tambah_direktorat').modal('show');
        });

        $('#store').click(function(e) {
            e.preventDefault();

            let direktorat = $('#direktorat').val();
            let lokasi = $('#lokasi').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('direktorat', direktorat);
            formData.append('lokasi', lokasi);
            formData.append('_token', token);

            $.ajax({
                url: '/direktorat',
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

                    load_datatable();
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.supplier && error.responseJSON
                        .supplier[0]) {
                        $('#alert-supplier').removeClass('d-none');
                        $('#alert-supplier').addClass('d-block');

                        $('#alert-supplier').html(error.responseJSON.supplier[0]);
                    }

                    if (error.responseJSON && error.responseJSON.alamat && error.responseJSON.alamat[
                        0]) {
                        $('#alert-alamat').removeClass('d-none');
                        $('#alert-alamat').addClass('d-block');

                        $('#alert-alamat').html(error.responseJSON.alamat[0]);
                    }
                }
            });
        });
    </script>

    <!-- Edit Data Jenis Barang -->
    <script>
        //Show modal edit
        $('body').on('click', '#button_edit_direktorat', function() {
            let direktorat_id = $(this).data('id');

            $.ajax({
                url: `/direktorat/${direktorat_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#direktorat_id').val(response.data.id);
                    $('#edit_direktorat').val(response.data.nama);
                    $('#edit_lokasi').val(response.data.lokasi);

                    $('#modal_edit_direktorat').modal('show');
                }
            });
        });

        // Proses Update Data
        $('#update').click(function(e) {
            e.preventDefault();

            let direktorat_id = $('#direktorat_id').val();
            let direktorat = $('#edit_direktorat').val();
            let lokasi = $('#edit_lokasi').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('direktorat', direktorat);
            formData.append('lokasi', lokasi);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/direktorat/${direktorat_id}`,
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

                    load_datatable();

                    $('#modal_edit_direktorat').modal('hide');
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.supplier && error.responseJSON
                        .supplier[0]) {
                        $('#alert-supplier').removeClass('d-none');
                        $('#alert-supplier').addClass('d-block');

                        $('#alert-supplier').html(error.responseJSON.supplier[0]);
                    }

                    if (error.responseJSON && error.responseJSON.alamat && error.responseJSON.alamat[
                        0]) {
                        $('#alert-alamat').removeClass('d-none');
                        $('#alert-alamat').addClass('d-block');

                        $('#alert-alamat').html(error.responseJSON.alamat[0]);
                    }
                }
            });
        });
    </script>

    <!-- Hapus Data Barang -->
    <script>
        $('body').on('click', '#button_hapus_supplier', function() {
            let supplier_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini !",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/direktorat/${supplier_id}`,
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
                            $(`#index_${supplier_id}`).remove();

                            $.ajax({
                                url: "/direktorat/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response) {
                                    let counter = 1;
                                    if ($.fn.DataTable.isDataTable('#table_id')) {
                                        $('#table_id').DataTable().destroy();
                                    }

                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value) {
                                        let direktorat = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.nama}</td>
                                            <td>${value.alamat}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_direktorat" data-id="${value.id}" class="mb-2 btn btn-icon btn-warning btn-lg"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_direktorat" data-id="${value.id}" class="mb-2 btn btn-icon btn-danger btn-lg"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                        $('#table_id').DataTable().row.add(
                                            $(direktorat)).draw(false);
                                    });
                                }
                            });
                        }
                    })
                }
            });
        });
    </script>
@endsection
