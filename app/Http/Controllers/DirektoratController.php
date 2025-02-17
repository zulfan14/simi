<?php

namespace App\Http\Controllers;

use App\Models\Direktorat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DirektoratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier.index', [
            'suppliers' => Direktorat::all()
        ]);
    }

    public function getDataDirektorat()
    {
        return response()->json([
            'success' => true,
            'data'    => Direktorat::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'direktorat'  => 'required',
            'lokasi'    => 'required'
        ],[
            'direktorat.required' => 'Form Nama Direktorat Wajib Di Isi !',
            'lokasi.required'   => 'Form lokasi Wajib Diisi'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $direktorat = Direktorat::create([
            'nama'      => $request->direktorat,
            'lokasi'    => $request->lokasi,
            'user_id'   => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $direktorat
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Direktorat $direktorat)
    {
        return response()->json([
            'success' => true,
            'message' => 'Edit Data Direktorat',
            'data'    => $direktorat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Direktorat $direktorat)
    {
        $validator = Validator::make($request->all(), [
            'direktorat'  => 'required',
            'lokasi'    => 'required'
        ],[
            'direktorat.required' => 'Form Nama Direktorat Wajib Di Isi !',
            'lokasi.required'   => 'Form Lokasi Wajib Diisi'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $direktorat->update([
            'nama'  => $request->direktorat,
            'lokasi'    => $request->lokasi,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $direktorat
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Direktorat $direktorat)
    {
        Direktorat::destroy($direktorat->id);
        
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }
}
