<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Amprahan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'isi', 'link', 'gambar','user_id', 'status'];
    protected $guarded = [''];

    // Amprahan.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
