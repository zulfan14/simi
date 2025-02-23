<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
                                     ->orderBy('created_at', 'desc')
                                     ->get();
        return response()->json($notifications);
    }

    public function markAsReadAndRedirect($id)
    {
        // Cari notifikasi berdasarkan ID
        $notification = Notification::findOrFail($id);

        // Tandai sebagai dibaca
        $notification->update(['is_read' => 1]);

        // Tentukan URL tujuan berdasarkan type
        $redirectUrl = '#';
        if ($notification->type == 1) {
            // Jika type 1, arahkan ke halaman detail barang
            $redirectUrl = route('barang.detail', ['id' => $notification->link]);
        } elseif ($notification->type == 2) {
            // Jika type 2, arahkan ke halaman detail amprahan
            $redirectUrl = route('amprahan.detail', ['id' => $notification->link]);
        }

        // Redirect ke URL yang sesuai
        return redirect()->to($redirectUrl);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
                    ->update(['is_read' => true]);

        return response()->json(['message' => 'All notifications marked as read.']);
    }
}
