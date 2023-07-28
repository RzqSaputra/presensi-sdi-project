<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;

class TaskAdminController extends Controller
{
    public function __construct(){
        $this->middleware('pm');
    }
    
    public function index(){
        $task = Task::with('user.karyawan')->get();
        return view('pm.task.index')->with([
            'title' => 'Task Karyawan',
            'task' => $task,
        ]);
    }

    public function edit($id){
         $task = Task::with('user.karyawan')->findOrFail($id);
         return view('pm.task.edit')->with([
            'title' => 'Edit Task Karyawan',
            'task' => $task,
         ]);
    }
}
