<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskKaryawanController extends Controller
{
    public function __construct(){
        $this->middleware('pm');
    }

    public function index(REquest $request){
        $tanggalAwal    = $request->input('filterTanggalAwal');
        $tanggalAkhir   = $request->input('filterTanggalAkhir');
        $task           = Task::with('user.karyawan')->when($tanggalAwal && $tanggalAkhir, 
        function ($query) use ($tanggalAwal, $tanggalAkhir) {
        return $query->whereBetween('tgl_task', 
        [$tanggalAwal, $tanggalAkhir]);})->get();
        
        return view('PM.Task.index')->with([
            'title' => 'Task Karyawan',
            'task' => $task,
            'tanggalAwal'   => $tanggalAwal,
            'tanggalAkhir'  => $tanggalAkhir,
        ]);
    }

    public function update($id){
         $task = Task::with('user.karyawan')->findOrFail($id);
         return view('PM.Task.edit')->with([
            'title' => 'Edit Task Karyawan',
            'task' => $task,
         ]);
    }
}
