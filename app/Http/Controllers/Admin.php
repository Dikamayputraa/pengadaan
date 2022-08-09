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

//import model 
use App\M_Admin;
use Firebase\JWT\Key;

class Admin extends Controller
{
    //
    public function index(){
        return view('admin.login');
    }

    //hapus ketika selesai develop
    // public function adminGenerate(){
    //     M_Admin::create(
    //         [
    //             'nama' => 'Admin',
    //             'email' => 'Admin@gmail.com',
    //             'alamat' => 'Jl.Lampung mo.02',
    //             'password' => encrypt("admin@gmail.com")
    //         ]
    //         );
    // }

    public function loginAdmin(Request $request){
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required'
            ]
            );

        $cek = M_Admin::where('email', $request->email)->count();
        $admin = M_Admin::where('email', $request->email)->get();

        if($cek > 0){
            foreach($admin as $adm ){
                if(decrypt($adm->password) == $request->password){
                    $key = env('APP_KEY');
                    $data = array('id_admin' => $adm->id_admin);
                    $jwt = JWT::encode($data, $key, 'HS256');

                    M_Admin::where('id_admin', $adm->id_admin)->update(
                        [
                            'token' => $jwt
                        ]
                        );

                    Session::put('token', $jwt);
                    return redirect('/pengajuan');
                }else{
                    return redirect('/loginAdmin')->with('gagal', 'Password Anda Salah!');
                }
            }
        }else{
            return redirect('/loginAdmin')->white('gagal', 'Email Tidak Terdaftar!');
        }
    }

    public function logoutAdmin(){
        $token = Session::get('token');

        if(M_Admin::where('token', $token)->update(
            [
                'token' => 'keluar'
            ]
            )){
                Session::put('token', '');
                return redirect('/loginAdmin')->with('berhasil', 'Anda Telah Logout');
            }else{
                return redirect('/')->with('gagal', 'Anda Gagal Logout!');
            }
    }

    public function listAdmin(){
        $token =  Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            $data['adm'] = M_Admin::where('token', $token)->first();;
            $data['admins'] = M_Admin::where('status', '1')->paginate(15);
            return view('admin.list', $data);
        }else{
            return redirect('/loginAdmin')->with('berhasil', 'Anda Telah Logout');
        }
    }

    public function registrasiAdmin(Request $request){
        $this->validate($request, 
            [
                'nama'          => "required",
                'email'         => "required",
                'alamat'        => "required",
                'password'      => "required"
            ]
        );

        //validasi session
        $token = Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            if (
                M_Admin::create(
                    [
                        "nama" => $request -> nama,
                        "email" => $request -> email,
                        "alamat" => $request -> alamat,
                        "password" => encrypt($request -> password)
                    ]
                )
            ) {
                return redirect('/listAdmin')->with("berhasil", "Data Berhasil Disimpan");
            }else{
                return redirect('/listAdmin')->with("gagal", " Data Gagal Disimpan!");
            }
        }else{
            return redirect('/loginAdmin')->with('berhasil', 'Anda Telah Logout');
        }
    }

    public function updateAdmin(Request $request){
        $this->validate($request, 
            [
                'ceknama'     => "required",
                'cekemail'    => "required",
                'cekalamat'   => "required"
            ]
        );

        //validasi session
        $token = Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            if (M_Admin::where('id_admin', $request->id_admin)->update(
                    [
                        "nama" => $request -> ceknama,
                        "email" => $request -> cekemail,
                        "alamat" => $request -> cekalamat
                    ]
                )
            ) {
                return redirect('/listAdmin')->with("berhasil", "Berhasil Update Data");
            }else{
                return redirect('/listAdmin')->with("gagal", " Gagal Update Data!");
            }
        }else{
            return redirect('/loginAdmin')->with('berhasil', 'Anda Telah Logout');
        }
    }

    public function deleteAdmin($id){
        //validasi session
        $token = Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            if (M_Admin::where('id_admin', $id)->delete()) {
                return redirect('/listAdmin')->with("berhasil", "Berhasil Hapus Data");
            }else{
                return redirect('/listAdmin')->with("gagal", " Gagal Hapus Data!");
            }
        }else{
            return redirect('/loginAdmin')->with('berhasil', 'Anda Telah Logout');
        }
    }

    public function passwordAdm(Request $request){
        $token =  Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){

            $sup = M_Admin::where('token', $token)->first();

            $Key = env('APP_KEY');
            $decode = JWT::decode($token, new Key($Key, 'HS256'));
            $decode_array = (array) $decode;

            if(decrypt($sup->password) == $request->passwordLama){
                if(M_Admin::where("id_admin",  $decode_array['id_admin'])->update([
                    "password" => encrypt($request->password)
                ])){
                    return redirect('/listAdmin')->with('berhasil', 'Password Berhasil Diupdate');
                }else{
                    return redirect('/listAdmin')->with('gagal', 'Password Gagal Diupdate');
                }
            }else{
                return redirect('/listAdmin')->with('gagal', 'Password Gagal Diupdate, Password Lama Tidak Sama!');
            }

        }else{
            return redirect('/listAdmin')->with('gagal', 'Password Gagal Diupdate, Password Lama Tidak Sama');
        }
    }

}
