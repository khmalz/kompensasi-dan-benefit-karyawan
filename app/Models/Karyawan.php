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

    // protected $casts = [
    //     'tanggal_masuk'  => 'date:Y-m-d',
    // ];

    // protected $date = ['tanggal_masuk'];

    public function getTanggalMasukAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
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
