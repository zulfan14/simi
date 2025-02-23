<?php 
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            $notifications = Notification::where('user_id', Auth::id())
                                        ->where('is_read', 0)
                                         ->orderBy('created_at', 'desc')
                                         ->take(4)
                                         ->get();
            $view->with('notifications', $notifications);
        });
    }

    public function register() {}
}
 ?>