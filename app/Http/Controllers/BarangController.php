<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
// use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Dompdf\Options;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;



class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('barang.index', [
            'barangs'         => Barang::all(),
            'jenis_barangs'   => Jenis::all(),
            'satuans'         => Satuan::all()
        ]);
    }

    public function getDataBarang()
    {
        $barangs = Barang::with(['direktorat', 'jenis'])->get();
        
        return response()->json([
            'success'   => true,
            'data'      => $barangs
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qty'           => 'required',
            'nama_barang'   => 'required',
            'gambar'        => 'mimes:jpeg,png,jpg',
            'tahun'         => 'required',
            'harga_satuan'         => 'required',
        ], [
            'qty.required'          => 'Jumlah Barang Wajib Di Isi !',
            'nama_barang.required'  => 'Form Nama Barang Wajib Di Isi !',
            'gambar.mimes'          => 'Gunakan Gambar Yang Memiliki Format jpeg, png, jpg !',
            'tahun.required'        => 'Tahun Perolehan Wajib Di Isi !',
            'harga_satuan.required'        => 'Harga Satuan Wajib Di Isi !',
        ]);

        if ($request->hasFile('gambar')) 
        {
            $path       = 'gambar-barang/';
            $file       = $request->file('gambar');
            $fileName   = $file->getClientOriginalName();
            $gambar     = $file->storeAs($path, $fileName, 'public');
        } else{
            $gambar = null;
        }

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = auth()->user();

        $barang = Barang::create([
            'qty'         => $request->qty,
            'nama_barang' => $request->nama_barang,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $path . $fileName,
            'tahun'       => $request->tahun,
            'lama_perbaikan'    => $request->lama_perbaikan,
            'direktorat_id'     => $user->direktorat_id,
            'is_aset'           => $request->is_aset,
            'jenis_id'          => $request->jenis_id,
            'kondisi_barang'    => $request->kondisi_barang,
            'harga_satuan'      => $request->harga_satuan,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $barang
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Barang',
            'data'    => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        return response()->json([
            'success' => true,
            'message' => 'Edit Data Barang',
            'data'    => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang'   => 'required',
            'deskripsi'     => 'required',
            'gambar'        => 'nullable|mimes:jpeg,png,jpg',
            'stok_minimum'  => 'required|numeric',
            'jenis_id'      => 'required',
            'satuan_id'      => 'required'
        ], [
            'nama_barang.required'  => 'Form Nama Barang Wajib Di Isi !',
            'deskripsi.required'    => 'Form Deskripsi Wajib Di Isi !',
            'gambar.mimes'          => 'Gunakan Gambar Yang Memiliki Format jpeg, png, jpg !',
            'stok_minimum.required' => 'Form Stok Minimum Wajib Di Isi !',
            'stok_minimum.numeric'  => 'Gunakan Angka Untuk Mengisi Form Ini !',
            'jenis_id.required'     => 'Pilih Jenis Barang !',
            'satuan_id.required'    => 'Pilih Satuan Barang !'
        ]);
    
        // cek apakah gambar diubah atau tidak
        if($request->hasFile('gambar')){
            // hapus gambar lama
            if($barang->gambar) {
                unlink('.'.Storage::url($barang->gambar));
            }
            $path       = 'gambar-barang/';
            $file       = $request->file('gambar');
            $fileName   = $file->getClientOriginalName();
            $gambar     = $file->storeAs($path, $fileName, 'public');
            $path      .= $fileName; 
        } else {
            // jika tidak ada file gambar, gunakan gambar lama
            $validator = Validator::make($request->all(), [
                'nama_barang'   => 'required',
                'deskripsi'     => 'required',
                'stok_minimum'  => 'required|numeric',
                'jenis_id'      => 'required',
                'satuan_id'      => 'required'
            ], [
                'nama_barang.required'  => 'Form Nama Barang Wajib Di Isi !',
                'deskripsi.required'    => 'Form Deskripsi Wajib Di Isi !',
                'stok_minimum.required' => 'Form Stok Minimum Wajib Di Isi !',
                'stok_minimum.numeric'  => 'Gunakan Angka Untuk Mengisi Form Ini !',
                'jenis_id.required'     => 'Pilih Jenis Barang !',
                'satuan_id.required'    => 'Pilih Satuan Barang !'
            ]);

            $path = $barang->gambar;
        } 
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
    
        $barang->update([
            'nama_barang'   => $request->nama_barang,
            'stok_minimum'  => $request->stok_minimum, 
            'deskripsi'     => $request->deskripsi,
            'user_id'       => auth()->user()->id,
            'gambar'        => $path,
            'jenis_id'      => $request->jenis_id,
            'satuan_id'     => $request->satuan_id
        ]);
    
        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $barang
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        unlink('.'.Storage::url($barang->gambar));
    
        Barang::destroy($barang->id);

        return response()->json([
            'success' => true,
            'message' => 'Data Barang Berhasil Dihapus!'
        ]);
    }

    public function showDetail($id)
    {
        // Mencari barang berdasarkan ID
        $barang = Barang::with(['direktorat', 'jenis'])->find($id);

        // Jika barang ditemukan, tampilkan ke view
        if ($barang) {
            return view('barang.detail', [
                'barang' => $barang
            ]);
        }

        // Jika barang tidak ditemukan, tampilkan pesan error
        return redirect()->route('barang.index')->with('error', 'Barang tidak ditemukan');
    }

    public function laporanPenyusutan()
    {
        // Ambil semua barang yang is_aset = 1
        $barangs = Barang::where('is_aset', 1)->get();

        // Buat array untuk laporan penyusutan
        $laporan = [];

        foreach ($barangs as $barang) {
            // Menghitung penyusutan
            $hargaPerolehan = $barang->harga_satuan;
            $tahunSekarang = Carbon::now()->year;
            $tahunPerolehan = Carbon::parse($barang->tahun)->year;  // Mengambil tahun saja

            $selisihTahun = $tahunSekarang - $tahunPerolehan;
            $persenPenyusutan = 5; // 5% per tahun

            // Pengurangan per tahun
            $pengurangan = max(0, $hargaPerolehan * ($persenPenyusutan / 100) * $selisihTahun);

            // Harga setelah penyusutan
            $hargaSetelahPenyusutan = max(0, $hargaPerolehan - $pengurangan);

            // Menambahkan data ke laporan
            $laporan[] = [
                'nama_aset' => $barang->nama_barang,
                'tahun_perolehan' => $tahunPerolehan,  // Menampilkan tahun saja
                'quantity' => $barang->qty,
                'harga_perolehan' => $barang->harga_satuan,
                'tahun_sekarang' => $tahunSekarang,
                'pengurangan' => $pengurangan,
                'harga_setelah_penyusutan' => $hargaSetelahPenyusutan,
            ];
        }

        // Tampilkan laporan
        return view('barang.laporan', ['laporan' => $laporan]);
    }


    public function data_penyusutan()
    {
        // Mengambil data barang yang is_aset = 1

        $data = $this->getDataPenyusutan();

        return response()->json([
            'success'   => true,
            'data'      => $data
        ]);
    }
    
    public function print_data_penyusutan()
    {
        $data_penyusutan = $this->getDataPenyusutan();

        // Konversi gambar ke base64
        $path = public_path('assets/img/kop.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = File::get($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->set_option('defaultPaperSize', 'A4');
        $dompdf->set_option('isRemoteEnabled', true);

        // Generate PDF
        $dompdf = new Dompdf();
        $html = view('/barang/print_penyusutan', compact('data_penyusutan', 'base64'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('print-amprahan.pdf', ['Attachment' => false]);

    }

    public function getDataPenyusutan()
    {
        $barangs = Barang::where('is_aset', 1)
            ->get();

        $data = [];
        
        foreach ($barangs as $barang) {
            // Menghitung penyusutan
            $hargaPerolehan = $barang->harga_satuan;
            $tahunSekarang = Carbon::now()->year;
            $tahunPerolehan = Carbon::parse($barang->tahun)->year; // Mengambil tahun saja
            
            $selisihTahun = $tahunSekarang - $tahunPerolehan;
            $persenPenyusutan = 5; // 5% per tahun

            // Pengurangan per tahun
            $pengurangan = max(0, $hargaPerolehan * ($persenPenyusutan / 100) * $selisihTahun);

            // Harga setelah penyusutan
            $hargaSetelahPenyusutan = max(0, $hargaPerolehan - $pengurangan);

            // Format data untuk dikirimkan ke client
            $data[] = [
                'id' => $barang->id,
                'nama_aset' => $barang->nama_barang,
                'tahun_perolehan' => $tahunPerolehan,
                'quantity' => $barang->qty,
                'harga_perolehan' => $hargaPerolehan,
                'tahun_sekarang' => $tahunSekarang,
                'pengurangan' => $pengurangan,
                'harga_setelah_penyusutan' => $hargaSetelahPenyusutan,
            ];
        }

        return $data;

    }

    public function kondisi_barang(){
        $years = range(date('Y'), 1990);

        $jenis_barang = Jenis::all(); // Ambil data jenis barang

        return view('laporan-kondisi-barang.index', compact('years', 'jenis_barang'));
    }

    public function fetch_kondisi_barang(Request $request)
    {
        // Ambil parameter dari request
        $kondisi = $request->kondisi;
        $tahun = $request->tahun;
        $jenis = $request->jenis;
        $start = $request->start; // Untuk menentukan offset
        $length = $request->length; // Untuk menentukan limit
        
        // Query dasar untuk mendapatkan data barang
        $query = Barang::with(['direktorat', 'jenis']);

        // Filter berdasarkan kondisi jika ada
        if ($kondisi) {
            $query->where('kondisi_barang', $kondisi);
        }

        // Filter berdasarkan tahun (created_at) jika ada
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        // Filter berdasarkan jenis jika ada
        if ($jenis) {
            $query->where('jenis_id', $jenis);
        }

        // Ambil data dengan pagination menggunakan offset dan limit dari request
        $barangs = $query->offset($start)->limit($length)->get();

        // Total records tanpa filter
        $totalRecords = Barang::count();

        // Total records setelah filter
        $filteredRecords = $query->count();

        return response()->json([
            "draw" => $request->draw,
            "recordsTotal" => $totalRecords, 
            "recordsFiltered" => $filteredRecords,
            "data" => $barangs
        ]);
    }


    public function fetch_jenis_barang()
    {
        $jenis_barang = Jenis::all(); // Ambil semua jenis barang dari tabel Jenis
        return response()->json([
            'success' => true,
            'data' => $jenis_barang
        ]);
    }

    public function print_laporan_barang(Request $request)
    {
         // Ambil parameter dari request
         $kondisi = $request->kondisi;
         $tahun = $request->tahun;
         $jenis = $request->jenis;
         
         // Query dasar untuk mendapatkan data barang
         $query = Barang::with(['direktorat', 'jenis']);
 
         // Filter berdasarkan kondisi jika ada
         if (!empty($kondisi)) {
             $query->where('kondisi_barang', $kondisi);
         }
 
         // Filter berdasarkan tahun (created_at) jika ada
         if (!empty($tahun)) {
             $query->whereYear('created_at', $tahun);
         }
 
         // Filter berdasarkan jenis jika ada
         if (!empty($jenis)) {
             $query->where('jenis_id', $jenis);
         }
 
         // Ambil data dengan pagination menggunakan offset dan limit dari request
         $barangs = $query->get();

        $path = public_path('assets/img/kop.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = File::get($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // Generate PDF
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->setPaper('A4', 'landscape');

        $html = view('/laporan-kondisi-barang/print_laporan_barang', compact('barangs', 'base64'))->render();

        $dompdf->loadHtml($html);
        $dompdf->render();

        // Mengirim file PDF untuk diunduh langsung oleh pengguna
        return $dompdf->stream('laporan_barang.pdf', ['Attachment' => false]);
    }


}
