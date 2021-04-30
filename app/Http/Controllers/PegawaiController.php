<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Pegawai;
use App\Unit;

class PegawaiController extends Controller
{
    //
    public function index()
    {
    	// mengambil semua data pengguna
    	$pegawai = User::all();
    	// return data ke view
    	return view('pegawai', ['pegawai' => $pegawai]);
    }

    public function tambah()
    {
        # code...
        $unit = Unit::all();
        return view('tambahpegawai', ['unit' => $unit]);
    }

    public function tambahpegawai(Request $request){
        
        $this->validate($request,[
            'username' => 'required|min:6',
            'name' => 'required',
            'no_hp' => 'required|min:10',
            'email' => 'required|email',
            'level' => 'required',
        ]);

        /*if ($errors)
        {
            // The Pesan
            $pesan = 'ada kesalahan dalam menyimpan data';
            
        }
        else{
            $pesan = 'data berhasil disimpan';
        }
        

        User::create([
    		'nama' => $request->nama,
    		'alamat' => $request->alamat
    	]);
        */

        $user = new User;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->unit_id = $request->unit;
        $user->password = Hash::make($request->username);
        $user->save();

        $pegawai = new Pegawai;
        $pegawai->alamat = $request->alamat;
        $pegawai->no_hp = $request->no_hp;
        $user->pegawai()->save($pegawai);

    	return redirect('/pegawai');
    }
}
