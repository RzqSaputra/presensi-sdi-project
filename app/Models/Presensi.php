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
        'jam_masuk',
        'foto_masuk',
        'lokasi_masuk',
        'jam_pulang',
        'foto_pulang',
        'lokasi_pulang',
        'status',
        'ket',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
