<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return response()->json(User::where('jabatan_id', 3)->with('karyawan')->get());
    }
    
    public function store(Request $request)
    {
        $validator = Validator::Make($request->all(), [
            'nip' => 'required|numeric|unique:App\Models\Pegawai,nip',
            'nama' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users',
            'j_k' => 'required',
            'no_tlp' => 'numeric|nullable',
            'jabatan_id' => 'required',
            'cabang_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            User::create([
                'nama' => $request->nama,
                'role' => 'Pegawai',
                'email' => $request->email,
                // default password jika admin menambahkan pegawai secara manual
                'password' => Hash::make('password'),
            ]);
            Pegawai::create([
                'user_id' => User::latest()->first()->id,
                'nip' => trim($request->nip),
                'j_k' => $request->j_k,
                'tgl_lahir' => $request->tgl_lahir,
                'no_tlp' => $request->no_tlp,
                'alamat' => $request->alamat,
                'jabatan_id' => $request->jabatan_id,
                'cabang_id' => $request->cabang_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'New Pegwai successfully added',
            ]);
        }
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(
            array_merge(
                json_decode($user, true),
                json_decode($user->pegawai, true)
            )
        );
    }
    public function update(Request $request, $id)
    {
        if ($request->idReset != '') {
            $validator = Validator::Make($request->all(), [
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            } else {
                User::where('id', $request->idReset)->update([
                    'password' => Hash::make($request->password),
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Password successfully updated',
                ]);
            }
        }
        $validator = Validator::Make($request->all(), [
            'nip' => [
                "required",
                "numeric",
                Rule::unique('pegawais')->ignore($id, 'user_id')
            ],
            'nama' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,id',
            'jabatan_id' => 'required',
            'j_k' => 'required',
            'no_tlp' => 'numeric|nullable',
            'jabatan_id' => 'required',
            'cabang_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            User::where('id', $id)->update([
                'nama' => $request->nama,
                'email' => $request->email,
            ]);
            Pegawai::where('user_id', $id)->update([
                'nip' => trim($request->nip),
                'j_k' => $request->j_k,
                'tgl_lahir' => $request->tgl_lahir,
                'no_tlp' => $request->no_tlp,
                'alamat' => $request->alamat,
                'jabatan_id' => $request->jabatan_id,
                'cabang_id' => $request->cabang_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Pegawai successfully updated',
            ]);
        }
    }
    public function destroy($id)
    {
        if (!User::destroy($id)) {
            return response()->json([
                'status' => 400,
                'errors' => 'Failed Deleted'
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Pegawai successfully deleted',
        ]);
    }
}
