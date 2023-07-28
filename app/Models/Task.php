<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\Paginator;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'judul',
        'deskripsi',
        'waktu_mulai',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user(){

        return $this->belongsTo(User::class);

    }

}
