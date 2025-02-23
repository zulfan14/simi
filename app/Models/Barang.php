<?php

namespace App\Models;

use App\Models\User;
use App\Models\Jenis;
use App\Models\Satuan;
use App\Models\BarangMasuk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Barang extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['qty', 'nama_barang', 'deskripsi', 'gambar', 'tahun', 'lama_perbaikan', 'is_aset', 'jenis_id', 'kondisi_barang', 'harga_satuan', 'direktorat_id', 'last_notified_at'];
    protected $guarded = [''];
    protected $ignoreChangedAttributes = ['updated_at'];


    public function getActivitylogAttributes(): array
    {
        return array_diff($this->fillable, $this->ignoreChangedAttributes);
    }

    // Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    // Satu Barang dimiliki oleh 1 User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Satu Barang memiliki 1 jenis
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }

    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class, 'direktorat_id');
    }
}
