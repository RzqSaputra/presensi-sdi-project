<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTask extends Model
{
    use HasFactory;
    protected $table = 'detail_task';
    protected $fillable =[
        'task_id',
        'kegiatan',
        'status',
        'mulai',
        'selesai',
        'ket',
        'bukti',
    ];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
