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
use App\M_Admin;
use App\M_Pengadaan;
use App\M_Suplier;
use App\M_Laporan;
use Illuminate\Foundation\Console\StorageLinkCommand;
use Illuminate\Support\Facades\Storage;

class Pengadaan extends Controller
{
    //
    public function index(){

        $token =  Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            $data['adm'] = M_Admin::where('token', $token)->first();
            $data['pengadaans'] = M_Pengadaan::where('status', '1')->paginate(15);
            return view("pengadaan.list", $data);
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
        }
    }

    public function tambahPengadaan(Request $request){
        //validasi session
        $token = Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();



        if($tokenDB > 0){
            $this->validate($request, 
                [
                    'nama_p'          => "required",
                    'deskripsi'         => "required",
                    'gambar'        => "required|image|mimes:jpg,png,jpeg|max:10000",
                    'anggaran'      => "required"
                ]
            );
                $path = $request->file('gambar')->store('public/gambar');
            if (
                M_Pengadaan::create(
                    [
                        "nama_pengadaan" => $request -> nama_p,
                        "deskripsi" => $request -> deskripsi,
                        "gambar" => $path,
                        "anggaran" => $request -> anggaran
                    ]
                )
            ) {
                return redirect('/listPengadaan')->with("berhasil", "Data Berhasil Disimpan");
            }else{
                return redirect('/listPengadaan')->with("gagal", " Data Gagal Disimpan!");
            }
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
         }
    }

    public function hapusGambar($id){
        $token = Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            $pengadaan = M_Pengadaan::where('id_pengadaan', $id)->count();
            if($pengadaan > 0){
                $dataPengadaan = M_Pengadaan::where('id_pengadaan', $id)->first();
                if(Storage::delete($dataPengadaan -> gambar)){
                    if(M_Pengadaan::where('id_pengadaan', $id)->update(['gambar' => '-'])){
                        return redirect('/listPengadaan')->with("berhasil", "Gambar Berhasil Dihapus");
                    }else{
                        return redirect('/listPengadaan')->with("gagal", "Gambar Gagal Dihapus");
                    }
                }else{
                    return redirect('/listPengadaan')->with("gagal", "Data Tidak Ditemukan!");
                }
            }
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
        }
    }

    public function uploadGambar(Request $request){
        //validasi session
        $token = Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            $this->validate($request, 
                [
                    'gambar' => "required|image|mimes:jpg,png,jpeg|max:10000",
                ]
            );
                $path = $request->file('gambar')->store('public/gambar');
            if (
                M_Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update(
                    [
                        "gambar" => $path,
                    ]
                )
            ) {
                return redirect('/listPengadaan')->with("berhasil", "Data Berhasil Disimpan");
            }else{
                return redirect('/listPengadaan')->with("gagal", " Data Gagal Disimpan!");
            }
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
         }
    }

    public function hapusPengadaan($id){
        $token = Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            $pengadaan = M_Pengadaan::where('id_pengadaan', $id)->count();
            if($pengadaan > 0){
                $dataPengadaan = M_Pengadaan::where('id_pengadaan', $id)->first();
                if(Storage::delete($dataPengadaan -> gambar)){
                    if(M_Pengadaan::where('id_pengadaan', $id)->delete()){
                        return redirect('/listPengadaan')->with("berhasil", "Data Berhasil Dihapus");
                    }else{
                        return redirect('/listPengadaan')->with("gagal", "Data Gagal Dihapus");
                    }
                }else{
                    return redirect('/listPengadaan')->with("gagal", "Data Tidak Ditemukan!");
                }
            }
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
        }
    }

    public function updatePengadaan(Request $request){
        //validasi session
        $token = Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            $this->validate($request, 
                [
                    'cekNama_p'          => "required",
                    'cekDeskripsi'         => "required",
                    'cekAnggaran'      => "required"
                ]
            );
            if (
                M_Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update(
                    [
                        "nama_pengadaan" => $request -> cekNama_p,
                        "deskripsi" => $request -> cekDeskripsi,
                        "anggaran" => $request -> cekAnggaran
                    ]
                )
            ) {
                return redirect('/listPengadaan')->with("berhasil", "Data Berhasil Disimpan");
            }else{
                return redirect('/listPengadaan')->with("gagal", " Data Gagal Disimpan!");
            }
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
         }
    }

    public function listSuplier(){

        $token =  Session::get('token');
        $tokenDB = M_Suplier::where('token', $token)->count();

        if($tokenDB > 0){
            $data['sup'] = M_Suplier::where('token', $token)->first();
            $data['pengadaans'] = M_Pengadaan::where('status', '1')->paginate(15);
            return view("suplier.pengadaan", $data);
        }else{
            return redirect('/login')->with("gagal", "Mohon Login Terlebih Dahulu!");
        }
    }

    public function tolakLaporan($id){
        $token = Session::get('token');
        $tokenDB = M_Admin::where('token', $token)->count();

        if($tokenDB > 0){
            $laporan = M_Laporan::where('id_laporan', $id)->count();
            if($laporan > 0){
                $datalaporan = M_Laporan::where('id_laporan', $id)->first();
                if(Storage::delete($datalaporan -> laporan)){
                    if(M_Laporan::where('id_laporan', $id)->delete()){
                        return redirect('/laporan')->with("berhasil", "Laporan Berhasil Ditolak");
                    }else{
                        return redirect('/laporan')->with("gagal", "Laporan Gagal Ditolak");
                    }
                }else{
                    return redirect('/laporan')->with("gagal", "Laporan Gagal Dihapus!");
                }
            }
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
        }
    }
}
