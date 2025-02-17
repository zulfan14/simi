@extends('layouts.app')

@section('content')

<div class="dashboard-first">
<div class="container">
    <div class="row">
        <h1 style="margin-top: 10px;">Laporan Barang</h1>
        <div class="ml-auto" style="margin-top: 10px;">
            <a href="javascript:void(0)" class="btn btn-danger" id="print-stok"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="opsi-laporan-stok">Filter Barang Berdasarkan :</label>
                        <select class="form-control" name="opsi-laporan-stok" id="opsi-laporan-stok">
                            <option value="1" selected>Baik</option>
                            <option value="2">Rusak Ringan</option>
                            <option value="3">Rusak</option>
                        </select>
                    </div>
                    
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-laporan-stok">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Dropdown -->
<script>
    $(document).ready(function() {
        var table = $('#table_id').DataTable({
            paging: true
        });

        loadData('semua');

        $('#opsi-laporan-stok').on('change', function(){
            var selectedOption = $(this).val();
            loadData(selectedOption);
        });

        function loadData(selectedOption) {
            $.ajax({
                url: '/laporan-stok/get-data',
                type: 'GET',
                data: { opsi: selectedOption },
                success: function(response){
                    table.clear().draw();

                    let counter = 1;
                    $.each(response, function(index, item) {
                        var row = [
                            counter++,
                            item.kode_barang,
                            item.nama_barang,
                            item.stok
                        ];
                        table.row.add(row); // Menambahkan baris data ke DataTables
                    });
                    table.draw();
                }
            });

        }

        $('#print-stok').on('click', function(){
            var selectedOption = $('#opsi-laporan-stok').val();
            window.location.href = '/laporan-stok/print-stok?opsi=' + selectedOption;
        });
    });
</script>

@endsection