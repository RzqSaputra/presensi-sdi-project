<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\DetailTask;
use Carbon\Carbon;

class DetailTaskController extends Controller
{
    public function lapor($id)
    {
        $task = Task::findOrFail($id);
        $detailtask = DetailTask::where('task_id', $id)
            ->orderBy('status', 'asc')
            ->get();
        return view('Karyawan.Task.lapor')->with([
            'title' => 'Lapor Kegiatan Task',
            'task' => $task,
            'detailtask' => $detailtask,
        ]);
    }

    public function create(Request $request, $task_id)
    { 
        $now = Carbon::now();
        $detailTask = DetailTask::create([
            'task_id' => $task_id,
            'kegiatan' => $request->kegiatan,
            'mulai' => $now->toTimeString(),
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Detail task berhasil dibuat.');
    }

    public function done(Request $request,$id)
    {   
        // dd($id);
        $request->validate([
            'bukti' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $image = $request->file('bukti');
        $imageName = time() . '_' . rand(10000, 99999) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/task'), $imageName);

        $task = DetailTask::find($id);
        $task->update([
            'bukti' => $imageName,
            'status' => 2,
            'selesai' => Carbon::now(),
            'ket' => 'Tolong, Diperiksa pekerjaan saya'
        ]);
        return back()->with('msg', 'Task Telah Diselesaikan');
    }

    public function cancel(Request $request,$id)
    {   
        // dd($request->all());
        $task = DetailTask::find($id);
        $task->update([
            'status' => 5,
            'selesai' => Carbon::now(),
            'ket' => $request->ket,
        ]);
        return back()->with('msg', 'Task Telah Dibatalkan');
    }
}
