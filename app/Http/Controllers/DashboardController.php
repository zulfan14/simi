<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangCount        = Barang::all()->count();
        $barangMasukCount   = BarangMasuk::all()->count();
        $barangKeluarCount  = BarangKeluar::all()->count();
        $userCount          = User::all()->count();
        $barangMasukPerBulan = BarangMasuk::selectRaw('DATE_FORMAT(tanggal_masuk, "%Y-%m") as date, SUM(jumlah_masuk) as total')
            ->groupBy('date')
            ->get()
            ->map(function ($data) {
                $data->date = date('Y-m', strtotime($data->date));
                $data->total = (int) $data->total;
                return $data;
        });
        $barangKeluarPerBulan = BarangKeluar::selectRaw('DATE_FORMAT(tanggal_keluar, "%Y-%m") as date, SUM(jumlah_keluar) as total')
            ->groupBy('date')
            ->get()
            ->map(function ($data) {
                $data->date = date('Y-m', strtotime($data->date));
                $data->total = (int) $data->total;
                return $data;
        });
    
        $barangMinimum = 1;
        
        $this->checkBarangForNotification(); // 🔔 Cek notifikasi setiap kali dashboard diakses
        $barangList = Barang::all();
        $notifications = Notification::where('user_id', auth()->id())
                                     ->orderBy('created_at', 'desc')
                                     ->take(4)
                                     ->get();
                                
        return view('dashboard', [
            'barang'            => $barangCount,
            'barangMasuk'       => $barangMasukCount,
            'barangKeluar'      => $barangKeluarCount,
            'user'              => $userCount,
            'barangMasukData'   => $barangMasukPerBulan,
            'barangKeluarData'  => $barangKeluarPerBulan,
            'barangMinimum'     => $barangMinimum,
            'notifications'     => $notifications,
        ]);
    }

    private function checkBarangForNotification()
    {
        $barangList = Barang::whereNotNull('lama_perbaikan')->get();

        foreach ($barangList as $barang) {
            $lastNotified = $barang->last_notified_at
                ? Carbon::parse($barang->last_notified_at)
                : Carbon::parse($barang->tahun);

            $nextNotificationDate = $lastNotified->addDays($barang->lama_perbaikan);

            if (Carbon::now()->greaterThanOrEqualTo($nextNotificationDate)) {
                $users = User::where(function ($query) use ($barang) {
                    $query->where('role_id', '!=', '3')
                        ->orWhere(function ($subQuery) use ($barang) {
                            $subQuery->where('role_id', '3')
                                    ->where('direktorat_id', $barang->direktorat_id);
                        });
                })->get();

                foreach ($users as $user) {
                    Notification::create([
                        'user_id' => $user->id,
                        'message' => " Perbaikan barang *{$barang->nama_barang}* sudah waktunya dilakukan.",
                        'type'    => 1,
                        'icon'    => 'fas fa-tools',
                        'link'    => $barang->id,
                    ]);
                }

                $barang->update(['last_notified_at' => Carbon::now()]);
            }
        }
    }

    /**
     * 📨 Tandai notifikasi sebagai telah dibaca.
     */
    public function markNotificationAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read_at' => Carbon::now()]);

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai telah dibaca.');
    }
}
