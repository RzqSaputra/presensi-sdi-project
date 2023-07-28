<?php

namespace App\Http\Controllers\PM;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\User;

class KaryawanController extends Controller
{
    public function __construct(){
        $this->middleware('pm');
    }

    public function index(Request $request){
        $karyawan = User::with('karyawan')->paginate(5);
        $jabatan = Jabatan::all();
        return view('PM.MasterData.Karyawan.index')->with([
            'title'     => 'Data Karyawan',
            'karyawan'   => $karyawan,
            'jabatan'   => $jabatan,
        ]);
    }

    public function create(Request $request){
        $validator = Validator::Make($request->all(), [
            'nip'        => 'required|numeric|unique:karyawans',
            'nama'       => 'required|min:3|max:50',
            'email'      => 'required|email|unique:users',
            'tgl_lahir'  => 'required',
            'jenkel'     => 'required',
            'alamat'     => 'required',
            'tlp'        => 'required',
        ]);

        User::create([
            'email'      => $request->email,
            'jabatan_id' => $request->jabatan_id,
            // default password jika admin menambahkan pegawai secara manual
            'password' => Hash::make('Password123'),
        ]);

        Karyawan::create([
            'user_id'    => User::latest()->first()->id,
            'jabatan_id' => $request->jabatan_id,
            'nip'        => trim($request->nip),
            'nama'       => $request->nama,
            'tgl_lahir'  => $request->tgl_lahir,
            'jenkel'     => $request->jenkel,
            'alamat'     => $request->alamat,
            'no_tlp'     => $request->no_tlp,
        ]);
        return redirect()->route('karyawan')->with('pesan',"Penambahan Data {$request['nama']} berhasil" );
    }

    public function update(Request $request, $id){
        User::where('id', $request->id)
        ->update([
            'email'      => $request->email,
            'jabatan_id' => $request->jabatan_id,
        ]);

        Karyawan::where('user_id',$request->id)
        ->update([
            'nama'       => $request->nama,
            'nip'        => $request->nip,
            'jenkel'     => $request->jenkel,
            'tgl_lahir'  => $request->tgl_lahir,
            'jabatan_id' => $request->jabatan_id,
            'no_tlp'     => $request->no_tlp,
            'alamat'     => $request->alamat,
        ]);
        
        session()->flash('pesan',"Perubahan Data {$request['nama']} berhasil");
        return redirect()->route('karyawan.profil', ['id' => $id]);
        
    }

    public function delete($id){
        $user = User::where('id',$id)->first();
        $user->delete();
        return redirect()->route('karyawan')->with('pesan',"Data berhasil dihapus" );
    }

    public function profil(Request $request, $id){
        $presensi = User::with('karyawan.jabatan')->findOrFail($id);
        $jabatan = Jabatan::where('id', '>', 1)->get();
        return view('PM.MasterData.Karyawan.profil')->with([
            'title' => 'Profile Karyawan',
            'presensi' => $presensi,
            'jabatan' => $jabatan,
        ]);
    }
    
    public function password(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->user->update([
            'password' => bcrypt($request->password),
        ]);

        session()->flash('pesan', "Perubahan Password {$karyawan->nama} berhasil");
        return redirect()->route('karyawan.profil', ['id' => $id]);
    }

    public function image(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $karyawan = Karyawan::findOrFail($id); // Mendapatkan data Karyawan berdasarkan ID yang diberikan

        if ($request->hasFile('image')) {
            
            $image = $request->file('image'); // Mengambil file gambar dari form upload
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate nama unik untuk gambar berdasarkan timestamp
            $image->move(public_path('FotoProfile'), $imageName); // Memindahkan file gambar ke folder yang diinginkan

            // Jika data Karyawan ditemukan, perbarui field foto
            $karyawan->foto = $imageName;
            $karyawan->save();
            return redirect()->back()->with('pesan', 'Gambar berhasil diunggah.');
        }

        return redirect()->back()->with('pesan', 'Gagal mengunggah gambar. Pastikan Anda memilih gambar yang valid.');
    }

}
