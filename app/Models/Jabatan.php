<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable =[
        'jabatan',
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
