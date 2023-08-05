<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Task;
use App\Models\TaskMingguan;
use App\Models\Presensi;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MenuPegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('pegawai');
    }

    public function index()
    {
        $title = 'Profil';
        return view('pegawai.profil', compact('title'));
    }

    public function PUpdate(Request $request, $id)
    {
        User::where('id', Auth::user()->id)
            ->update([
                'nama' => $request->nama,
                'email' => $request->email,
            ]);

        Pegawai::where('user_id', Auth::user()->id)
            ->update([
                'nip' => $request->nip,
                'tgl_lahir' => $request->tgl_lahir,
                'j_k' => $request->j_k,
                'no_tlp' => $request->no_tlp,
                'alamat' => $request->alamat,
                'jabatan_id' => $request->jabatan_id,
                'cabang_id' => $request->cabang_id,
            ]);
            session()->flash('pesan', "Update Profil {$request->nama} berhasil");
        return redirect(route('profil.index'));
    }

    public function updatePassword(Request $request){
        $validatePass = $request->validate([
            'current_password'=> 'required',
            'password' => ['required','min:6','confirmed']
        ]);

        if(Hash::check($request->current_password, auth()->user()->password)){
            auth()->user()->update(['password'=>Hash::make($request->password)  ]);
            session()->flash('pesan', "Update Password berhasil");
            return redirect(route('profil.index'));
        }

    }

    


    //PRESENSI
    public function presensi()
    {
        $title = 'Presensi';
        $today = Carbon::now()->toDateString();
        $presensi = Presensi::where('user_id', Auth::user()->id)->where('tgl_presensi', $today)->first();
        $status = $presensi->status ?? "status";
        return view('pegawai.presensi', compact('title', 'presensi', 'status'));
    }


    //TASK HARIAN
    public function task(Request $request)
    {
        $usr_id = Auth::user()->id;
        $title = 'Task Harian';
        $task = Task::all();    
        $status = [
            [
                'label' => 'Proses',
                'value' => 'Proses',
            ],
            [
                'label' => 'Selesai',
                'value' => 'Selesai',
            ]
        ];
        return view('pegawai.task', compact('title', 'task','status', 'usr_id'));
    }

    public function tambahTaskHarian(Request $request)
    {
        $waktu_mulai = date('Y-m-d H:i:s');
        $data = [
            'user_id' => Auth::user()->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'waktu_mulai' => $waktu_mulai,
            'status' => $request->status,
        ];
        Task::create($data);

        return redirect()->route('pegawai.task');
    }

    public function updateTask(Request $request) {
        $taskM = Task::where('id', $request->id)
        ->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect()->route('pegawai.task');
    }

    public function deleteTask(Request $request) {
        $task = Task::where('id',$request->id)->first();
        if($task != null){
            $task->delete();
            return redirect()->route('pegawai.task')->with('msg',"Task {$task['task']} berhasil dihapus" );
        }
    }


    //Task Mingguan
    public function task_mingguan(Request $request)
    {
        $title = 'Task Mingguan';
        $usr_id = Auth::user()->id;
        $taskM = TaskMingguan::all();
        $status = [
            [
                'label' => 'Belum',
                'value' => 'Belum',
            ],
            [
                'label' => 'Proses',
                'value' => 'Proses',
            ],
            [
                'label' => 'Sudah',
                'value' => 'Sudah',
            ]
        ];
        return view('pegawai.taskM', compact('title', 'taskM','usr_id', 'status'));
    }

    public function tambahTaskMingguan(Request $request)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'task_mingguan' => $request->task_mingguan,
            'status' => $request->status,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai
        ];
        TaskMingguan::create($data);

        return redirect()->route('pegawai.task_mingguan');
    }

    public function updateTaskM(Request $request) {
        $taskM = TaskMingguan::where('id', $request->id)
        ->update([
            'task_mingguan' => $request->task_mingguan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => $request->status,
        ]);

        return redirect()->route('pegawai.task_mingguan');
    }

    public function deleteTaskM(Request $request) {
        $taskM = TaskMingguan::where('id',$request->id)->first();
        if($taskM != null){
            $taskM->delete();
            return redirect()->route('pegawai.task_mingguan')->with('msg',"Task {$taskM['task_mingguan']} berhasil dihapus" );
        }
    }
}
