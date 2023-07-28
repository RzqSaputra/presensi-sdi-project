<?php

namespace App\Http\Controllers\PM;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function __construct(){
        $this->middleware('pm');
    }

     public function index(Request $request){
        $jabatan = Jabatan::paginate(5);
        return view('PM.MasterData.Jabatan.index')->with([
            'title'     => 'Data Jabatan',
            'jabatan'   => $jabatan,
        ]);
    }


    public function create(Request $request){
        $validator = Validator::Make($request->all(), [
            'jabatan'        => 'required',
        ]);

        Jabatan::create([
            'jabatan' => $request->jabatan,
        ]);
        return redirect()->route('jabatan')->with('pesan',"Penambahan Jabatan {$request['jabatan']} berhasil" );
    }


    public function update(Request $request, $id){
        Jabatan::where('id', $request->id)
        ->update([
            'jabatan'       => $request->jabatan,
        ]);

        session()->flash('pesan',"Perubahan Data {$request['jabatan']} berhasil");
        return redirect()->route('jabatan');
        
    }


    public function delete($id){
        $user = Jabatan::where('id',$id)->first();
        $user->delete();
        return redirect()->route('jabatan')->with('pesan',"Data berhasil dihapus" );
    }
}
