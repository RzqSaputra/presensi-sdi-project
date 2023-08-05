<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('karyawan');
    }

    public function index()
    {
        $task = Task::get();
        return view('Karyawan.Task.index')->with([
            'title' => 'Task',
            'task' => $task,
        ]);
    }
}
