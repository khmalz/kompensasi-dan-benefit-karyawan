<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tunjangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $primaryKey = 'nik';
    public $incrementing = false;

    public function getTanggalMasukAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('d F Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tunjangan()
    {
        return $this->hasMany(Tunjangan::class, 'karyawan_nik');
    }
}
