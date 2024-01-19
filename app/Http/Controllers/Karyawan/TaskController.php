<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Task;
use App\Models\DetailTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('karyawan');
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $tasksHarian = Task::where('user_id', $user_id)
            ->orderByDesc('id')
            ->get();

        return view('Karyawan.Task.index')->with([
            'title' => 'Tugas Harian',
            'tasksHarian' => $tasksHarian,
        ]);
    }


    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis'     => 'required|in:1,2',
            'foto'      => 'required|image|mimes:jpeg,png,jpg,gif|max:10048',
        ]);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/task'), $imageName);
        }

        Task::create([
            'user_id'   => Auth::user()->id,
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tgl_task'  => Carbon::today(),
            'mulai'     => Carbon::now(),
            'jenis'     => $request->jenis,
            'status'    => 1,
            'foto'      => $imageName,
        ]);

        return back()->with('msg', 'Task berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis' => 'required|in:1,2',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
        ]);

        $task = Task::find($id);

        $data = [
            'user_id' => Auth::user()->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tgl_task' => Carbon::today(),
            'mulai' => Carbon::now(),
            'jenis' => $request->jenis,
        ];

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/task'), $imageName);
            $data['foto'] = $imageName;
        } elseif ($task->foto) {
            $data['foto'] = $task->foto;
        }

        Task::where('id', $id)->update($data);

        return back()->with('msg', 'Task berhasil diperbaharui.');
    }

}
