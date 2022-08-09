<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

//import lib session
use Illuminate\Support\Facades\Session;

//import
use \Firebase\JWT\JWT;

//import lib validator
use Illuminate\Support\Facades\Validator;

//import lib encrypt
use Illuminate\Contracts\Encryption\DecryptExeption;

//import model M_Suplier
use App\M_Suplier;
use App\M_Admin;

use Firebase\JWT\Key;

class Suplier extends Controller
{
    //
    public function index(){
        return view('suplier.login');
    }

    public function loginSuplier(Request $request){
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );

        $cek = M_Suplier::where('email', $request->email)->count();
        $sup = M_Suplier::where('email', $request->email)->get();

        if ($cek > 0) {
            foreach ($sup as $s){
                if (decrypt($s->password) == $request->password) {
                    $key = env('APP_KEY');
                    $data = array("id_suplier" => $s->id_suplier);
                    $jwt = JWT::encode($data,$key, 'HS256');

                    M_Suplier::where("id_suplier", $s->id_suplier)->update(
                        [
                            'token' => $jwt
                        ]
                    );

                    Session::put('token', $jwt);
                    return redirect('/listSuplier');
                }else{
                    return redirect('/login')->with("gagal", "Password Anda Salah!");
                }
            }
        }else{
            return redirect('/login')->with('gagal', 'Email Tidak Terdaftar');
        }
    }

    public function logoutSuplier(){
        $token = Session::get('token');

        if(M_Suplier::where('token', $token)->update(
            [
                'token' => 'keluar',
            ]
        )){
            Session::put('token', '');
            return redirect('/');
        }else{
            return redirect('/loginSuplier')->with('gagal', 'Anda Gagal Logout!');
        }
    }

    public function listSuplier(){
        $token =  Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            $data['adm'] = M_Admin::where('token', $token)->first();;
            $data['suplier'] = M_Suplier::paginate(15);
            return view('admin.listSuplier', $data);
        }else{
            return redirect('/loginAdmin')->with('berhasil', 'Anda Telah Logout');
        }
    }

    public function nonAktif($id){
        $token =  Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            if(M_Suplier::where("id_suplier", $id)->update([
                "status" => "0"
            ])){
                return redirect('/listSup')->with('berhasil', 'Data Berhasil Diupdate');
            }else{
                return redirect('/listSup')->with('gagal', 'Data Gagal Diupdate');
            }
        }else{
            return redirect('/loginAdmin')->with('berhasil', 'Anda Telah Logout');
        }
    }

    public function Aktif($id){
        $token =  Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            if(M_Suplier::where("id_suplier", $id)->update([
                "status" => "1"
            ])){
                return redirect('/listSup')->with('berhasil', 'Data Berhasil Diupdate');
            }else{
                return redirect('/listSup')->with('gagal', 'Data Gagal Diupdate');
            }
        }else{
            return redirect('/loginAdmin')->with('berhasil', 'Anda Telah Logout');
        }
    }

    public function password(Request $request){
        $token =  Session::get('token');
        $tokenDB = M_Suplier::where('token', $token)->count();

        if($tokenDB > 0){

            $sup = M_Suplier::where('token', $token)->first();

            $Key = env('APP_KEY');
            $decode = JWT::decode($token, new Key($Key, 'HS256'));
            $decode_array = (array) $decode;

            if(decrypt($sup->password) == $request->passwordLama){
                if(M_Suplier::where("id_suplier",  $decode_array['id_suplier'])->update([
                    "password" => encrypt($request->password)
                ])){
                    return redirect('/listSuplier')->with('berhasil', 'Password Berhasil Diupdate');
                }else{
                    return redirect('/listSuplier')->with('gagal', 'Password Gagal Diupdate');
                }
            }else{
                return redirect('/listSuplier')->with('gagal', 'Terjadi Kesalahan!, Penggantian Pasword Berulang!');
            }

        }else{
            return redirect('/listSuplier')->with('gagal', 'Password Gagal Diupdate, Password Lama Tidak Sama');
        }
    }
}
