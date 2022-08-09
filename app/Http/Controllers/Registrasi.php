<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

//import library fungsi validate laravel
use Illuminate\Support\Facades\Validator;

//import model M_Suplier
use App\M_Suplier;
use Illuminate\Support\Facades\Session;

//import lib encript
use Illuminate\Contracts\Encryption\DecryptExeption;

class Registrasi extends Controller
{
    //

    public function index(){
        $key = env('APP_KEY');
        $token = Session::get('token');
    
        $tokenDb = M_Suplier::where('token', $token)->count();
    
        if($tokenDb > 0){
            $data['token'] = $token;
        }else{
            $data['token'] = "kosong";
            return view('registrasi.registrasi', $data);
        }

        return view('registrasi.registrasi', $data);

        
    }
    public function registrasi(Request $request){
        $this->validate($request, 
            [
                'nama_usaha'    => "required",
                'email'         => "required",
                'alamat'        => "required",
                'no_npwp'       => "required",
                'password'      => "required"
            ]
        );

        if (
            M_Suplier::create(
                [
                    "nama_usaha" => $request -> nama_usaha,
                    "email" => $request -> email,
                    "alamat" => $request -> alamat,
                    "no_npwp" => $request -> no_npwp,
                    "password" => encrypt($request -> password)
                ]
            )
        ) {
            return redirect('/registrasi')->with("berhasil", "Berhasil Membuat Akun!");
        }else{
            return redirect('/registrasi')->with("gagal", "Terjadi Kesalahan! Tidak Dapat Membuat Akun!");
        }
    }
}
