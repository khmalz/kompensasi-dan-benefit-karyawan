<?php

namespace App\Models;

use App\Models\Tunjangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tanggapan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tunjangan()
    {
        return $this->belongsTo(Tunjangan::class, 'kode_tunjangan');
    }
}
