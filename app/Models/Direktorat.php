<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Direktorat extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['nama', 'lokasi'];
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

    // 1 Supplier memiliki banyak barangMasuk
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

     public function users()
     {
         return $this->hasMany(User::class, 'direktorat_id'); // 'direktorat_id' adalah foreign key di tabel user
     }
}
