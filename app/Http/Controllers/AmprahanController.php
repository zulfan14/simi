<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amprahan;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\File;

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
        $role_user = auth()->user()->role->role;

        $amprahan = $amprahan->map(function ($item) use ($role_user) {
            $item->role_user = $role_user;
            return $item;
        });
    

        return response()->json([
            'success' => true,
            'data'    => $amprahan
        ]);
    }

    public function printAmprahan($id)
    {
        $amprahan = Amprahan::with(['user'])->findOrFail($id);

        // Konversi gambar ke base64
        $path = public_path('assets/img/kop.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = File::get($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->set_option('defaultPaperSize', 'A4');
        $dompdf->set_option('isRemoteEnabled', true);

        // Generate PDF
        $dompdf = new Dompdf();
        $html = view('/amprahan/print', compact('amprahan', 'base64'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('print-amprahan.pdf', ['Attachment' => false]);
    }


}
