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
        'mulai',
        'selesai',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function detail_task(){
        return $this->hasOne(DetailTask::class);
    }

}
