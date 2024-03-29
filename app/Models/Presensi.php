<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable =[
        'user_id',
        'tgl_presensi',
        'mulai',
        'foto_masuk',
        'lokasi_masuk',
        'selesai',
        'foto_pulang',
        'lokasi_pulang',
        'status',
        'ket',
        'file',
        'total_masuk',
        'total_izin',
        'total_telat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
