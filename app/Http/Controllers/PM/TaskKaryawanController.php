<?php

namespace App\Http\Controllers\PM;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\DetailTask;
use Carbon\Carbon;

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
        $user           = User::all();
        return view('PM.Task.index')->with([
            'title' => 'Task Karyawan',
            'task' => $task,
            'tanggalAwal'   => $tanggalAwal,
            'tanggalAkhir'  => $tanggalAkhir,
            'user'  => $user,
        ]);
    }

    public function create(Request $request)
    {
        $mulai    = Carbon::now();
        $validator = Validator::Make($request->all(), [
            'user_id'     => 'required',
            'nama'        => 'required',
            'mulai'       => 'required|date',
        ]);

        Task::create([
            'user_id'  => $request->user_id,
            'judul'    => $request->judul,
            'mulai'    => $mulai,
            'status'   => 1,
        ]);

        return redirect()->route('taskKaryawan')->with('msg',"Penambahan Task berhasil" );
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'tgl_task' => 'required|date',
            'status' => 'nullable|string',
        ]);

        $task = Task::findOrFail($id);

        $task->update($validatedData);

        return redirect()->route('taskKaryawan')->with('msg', 'Task berhasil diperbarui.');
    }

    public function delete($id){
        $user = Task::where('id',$id)->first();
        $user->delete();
        return redirect()->route('taskKaryawan')->with('msg', "Task berhasil dihapus" );
    }

    public function detail($id)
    {
        $task = Task::findOrFail($id);
        $detailtask = DetailTask::where('task_id', $id)
            ->orderBy('status', 'asc')
            ->get();
        return view('PM.Task.detail')->with([
            'title' => 'Detail Task Karyawan',
            'task' => $task,
            'detailtask' => $detailtask,
        ]);
    }

    public function done($id)
    {
        $task = DetailTask::find($id);
        $task->update([
            'status' => 3,
            'selesai' => Carbon::now(),
        ]);

       
        return back()->with('msg', 'Task Diterima');
    }

    public function revisi(Request $request,$id)
    {
        $task = DetailTask::find($id);
        $task->update([
            'status' => 4,
            'selesai' => Carbon::now(),
            'ket' => $request->ket,
        ]);
        return back()->with('msg', 'Task Diterima');
    }

    public function selesai($id)
    {
        $task = Task::find($id);
        $task->update([
            'status' => 2,
            'selesai' => Carbon::now(),
        ]);
        return back()->with('msg', 'Task Diselesaikan');
    }
}   
