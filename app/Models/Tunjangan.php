<?php

namespace App\Models;

use App\Models\Tanggapan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tunjangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'kode';
    public $incrementing = false;

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_nik');
    }

    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class, 'kode_tunjangan');
    }

    public function getRouteKeyName()
    {
        return 'kode';
    }
}
