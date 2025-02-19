<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amprahan;
use Dompdf\Dompdf;

class AmprahanController extends Controller
{
    public function index()
    {
        return view('amprahan.index', [
            'amprahan' => Amprahan::all()
        ]);
    }

    public function getDataAmprahan()
    {
        $amprahan = Amprahan::with(['user'])->get();

        return response()->json([
            'success' => true,
            'data'    => $amprahan
        ]);
    }

    public function printAmprahan($id)
{
    $amprahan = Amprahan::with(['user'])->findOrFail($id);

    // Menggunakan path absolut untuk gambar
    $kopSuratPath = public_path('assets/img/kop.png');

    // Generate PDF
    $dompdf = new Dompdf();
    $html = view('/amprahan/print', compact('amprahan', 'kopSuratPath'))->render();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('print-amprahan.pdf', ['Attachment' => false]);
}

}
