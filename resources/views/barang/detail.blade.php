@extends('layouts.app')

@section('content')
<div class="dashboard-first">
    <div class="container">
        <div class="row">
            <h1 style="margin-top: 10px;">Detail Barang</h1>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_barang" value="{{ $barang->nama_barang }}" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="deskripsi" rows="3" disabled>{{ $barang->deskripsi }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="qty" class="col-sm-3 col-form-label">Kuantitas</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="qty" value="{{ $barang->qty }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tahun" class="col-sm-3 col-form-label">Tahun Perolehan</label>
                                <div class="col-sm-9">
                                    <!-- Format tanggal Indonesia -->
                                    <input type="text" class="form-control" id="tahun" value="{{ \Carbon\Carbon::parse($barang->tahun)->format('d-m-Y') }}" disabled>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="lama_perbaikan" class="col-sm-3 col-form-label">Lama Perbaikan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="lama_perbaikan" value="{{ $barang->lama_perbaikan }} hari" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="kondisi_barang" class="col-sm-3 col-form-label">Kondisi Barang</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kondisi_barang" value="{{ $barang->kondisi_barang == 1 ? 'Baik' : 'Rusak' }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="harga_satuan" class="col-sm-3 col-form-label">Harga Satuan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="harga_satuan" value="Rp. {{ number_format($barang->harga_satuan, 0, ',', '.') }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gambar" class="col-sm-3 col-form-label">Gambar Barang</label>
                                <div class="col-sm-9">
                                    <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang" class="img-fluid" width="300">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="direktorat" class="col-sm-3 col-form-label">Direktorat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="direktorat" value="{{ $barang->direktorat->nama ?? 'Tidak ada data' }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jenis_barang" class="col-sm-3 col-form-label">Jenis Barang</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jenis_barang" value="{{ $barang->jenis->jenis_barang ?? 'Tidak ada data' }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_notified_at" class="col-sm-3 col-form-label">Terakhir Diberitahukan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="last_notified_at" value="{{ $barang->last_notified_at }}" disabled>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
