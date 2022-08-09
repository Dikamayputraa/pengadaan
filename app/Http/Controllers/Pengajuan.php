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
use App\M_Pengajuan;
use App\M_Suplier;
use App\M_Laporan;

// use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Pengajuan extends Controller
{
    //
    public function pengajuan(){
        $key = env('APP_KEY');
        $token = Session::get('token');
        $tokenDB = M_Admin::where("token", $token)->count();

        if($tokenDB > 0){
            $data['adm'] = M_Admin::where('token', $token)->first();
            $pengajuans = M_Pengajuan::where('status', '1')->paginate(15);
            $dataP = array();

            foreach($pengajuans as $pengajuan){
                $pengadaan = M_Pengadaan::where('id_pengadaan', $pengajuan -> id_pengadaan)->first();
                $suplier = M_Suplier::where('id_suplier', $pengajuan -> id_suplier)->first();

                $dataP[] = array(
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'status_pengajuan' => $pengajuan->status,
                    'anggaran_pengajuan' => $pengajuan->anggaran,
                    'proposal' => $pengajuan->proposal,

                    'anggaran' => $pengadaan->anggaran,
                    'nama_pengadaan' => $pengadaan->nama_pengadaan,
                    'gambar' => $pengadaan->gambar,

                    'nama_suplier' => $suplier  -> nama_usaha,
                    'email_suplier' => $suplier -> email,
                    'alamat_suplier' => $suplier-> alamat,
                );
            }

            $data['pengajuan'] = $dataP;
            return view('pengajuan.list', $data);
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Anda Belum Login');
        }
    }

    public function tambahPengajuan(Request $request){
        $Key = env('APP_KEY');
        //validasi session
        
        $token = Session::get('token');
        $tokenDB = M_Suplier::where('token', $token)->count();

        $decode = JWT::decode($token, new Key($Key, 'HS256'));
        $decode_array = (array) $decode;
        // echo "Decode:\n" . print_r($decode_array, true) . "\n";

        
        if($tokenDB > 0){ 
            $this->validate($request, 
                [
                    'id_pengadaan'  => "required",
                    'proposal'      => "required|mimes:pdf|max:10000",
                    'anggaran'      => "required"
                ]
            );

            $cekPengajuan = M_Pengajuan::where('id_suplier', $decode_array['id_suplier'])->where('id_pengadaan', $request->id_pengadaan)->count();
            if($cekPengajuan == 0){
                $path = $request->file('proposal')->store('public/proposal');
                if (M_Pengajuan::create([
                            "id_pengadaan" => $request -> id_pengadaan,
                            "id_suplier"   => $decode_array['id_suplier'],
                            "proposal"     => $path,
                            "anggaran"     => $request -> anggaran
                        ])) {
                    return redirect('/listSuplier')->with("berhasil", "Berhasil Melakukan Pengajuan");
                }else{
                    return redirect('/listSuplier')->with("gagal", "Gagal Melakukan Pengajuan, Mohon Hubingi Admin");
                }
            }else{
                // echo "Decode:\n" . print_r($decode_array, true) . "\n";
                return redirect('/listSuplier')->with('gagal', 'Pengajuan Sudah Pernah Dilakukan');
            }
                
        }else{
            return redirect('/login')->with('gagal', 'Mohon Login Terlebih Dahulu!');
         }
    }

    public function terimaPengajuan($id){
        $token = Session::get('token');
        $tokenDB = M_Admin::where("token", $token)->count();

        if($tokenDB > 0){
            if(M_Pengajuan::where('id_pengajuan', $id)->update([
                'status' => '2'
            ])){
                return redirect('/pengajuan')->with('berhasil', 'Status Pengajuan Berhasil Diubah');
            }else{
                return redirect('/pengajuan')->with('gagal', 'Status Pengajuan Gagal Diubah!');
            }
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
        }
    }

    public function tolakPengajuan($id){
        $token = Session::get('token');
        $tokenDB = M_Admin::where("token", $token)->count();

        if($tokenDB > 0){
            if(M_Pengajuan::where('id_pengajuan', $id)->update([
                'status' => '0'
            ])){
                return redirect('/pengajuan')->with('berhasil', 'Status Pengajuan Berhasil Diubah');
            }else{
                return redirect('/pengajuan')->with('gagal', 'Status Pengajuan Gagal Diubah!');
            }
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
        }
    }

    public function history(){
        $Key = env('APP_KEY');
        //validasi session
        
        $token = Session::get('token');
        $tokenDB = M_Suplier::where('token', $token)->count();

        $decode = JWT::decode($token, new Key($Key, 'HS256'));
        $decode_array = (array) $decode;

        if($tokenDB > 0){    
            $data['sup'] = M_Suplier::where('token', $token)->first();

            $pengajuans = M_Pengajuan::where('id_suplier', $decode_array['id_suplier'])->get();             
            $dataArr = array();

            foreach($pengajuans as $pengajuan){
                $pengadaan = M_Pengadaan::where('id_pengadaan', $pengajuan -> id_pengadaan)->first();
                $suplier = M_Suplier::where('id_suplier', $decode_array['id_suplier'])->first();

                $lapCount = M_Laporan::where('id_pengajuan', $pengajuan -> id_pengajuan)->count();
                $lap = M_Laporan::where('id_pengajuan', $pengajuan -> id_pengajuan)->first();

                if($lapCount > 0){
                    $lapLink = $lap->laporan;
                }else{
                    $lapLink = "-";
                }

                $dataArr[] = array(
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'status_pengajuan' => $pengajuan->status,
                    'anggaran_pengajuan' => $pengajuan->anggaran,
                    'proposal' => $pengajuan->proposal,

                    'anggaran' => $pengadaan->anggaran,
                    'nama_pengadaan' => $pengadaan->nama_pengadaan,
                    'gambar' => $pengadaan->gambar,

                    'nama_suplier' => $suplier  -> nama_usaha,
                    'email_suplier' => $suplier -> email,
                    'alamat_suplier' => $suplier-> alamat,

                    'laporan' => $lapLink,
                );
            }

            $data['pengajuan'] = $dataArr;
            return view('suplier.history', $data);
            
        }else{
            return redirect('/listSuplier')->with('gagal', 'Mohon Login Terlebih Dahulu!');
         }
    }

    public function tambahLaporan(Request $request){
        $Key = env('APP_KEY');
        //validasi session
        
        $token = Session::get('token');
        $tokenDB = M_Suplier::where('token', $token)->count();

        $decode = JWT::decode($token, new Key($Key, 'HS256'));
        $decode_array = (array) $decode;
        // echo "Decode:\n" . print_r($decode_array, true) . "\n";

        
        if($tokenDB > 0){ 
            $this->validate($request, 
                [
                    'id_pengajuan'  => "required",
                    'laporan'      => "required|mimes:pdf|max:10000",

                ]
            );

            $cekLaporan = M_Laporan::where('id_suplier', $decode_array['id_suplier'])->where('id_pengajuan', $request->id_pengajuan)->count();
            if($cekLaporan == 0){
                $path = $request->file('laporan')->store('public/laporan');
                if (M_Laporan::create([
                            "id_pengajuan" => $request -> id_pengajuan,
                            "id_suplier"   => $decode_array['id_suplier'],
                            "laporan"     => $path,
                        ])) {
                    return redirect('/history')->with("berhasil", "Laporan Berhasil Diupload");
                }else{
                    return redirect('/history')->with("gagal", "Laporan Gagal Diupload!");
                }
            }else{
                // echo "Decode:\n" . print_r($decode_array, true) . "\n";
                return redirect('/history')->with('gagal', 'Laporan Sudah Pernah Diupload');
            }
                
        }else{
            return redirect('/login')->with('gagal', 'Mohon Login Terlebih Dahulu!');
         }
    }

    public function laporan(){
        $key = env('APP_KEY');
        $token = Session::get('token');
        $tokenDB = M_Admin::where("token", $token)->count();

        if($tokenDB > 0){
            $pengajuans = M_Pengajuan::where('status', '2')->paginate(15);
            $data['adm'] = M_Admin::where('token', $token)->first();
            $dataP = array();

            foreach($pengajuans as $pengajuan){
                $pengadaan = M_Pengadaan::where('id_pengadaan', $pengajuan -> id_pengadaan)->first();
                $suplier = M_Suplier::where('id_suplier', $pengajuan -> id_suplier)->first();

                $cekLaporan = M_Laporan::where('id_pengajuan', $pengajuan -> id_pengajuan)->count();
                $laporan = M_Laporan::where('id_pengajuan', $pengajuan -> id_pengajuan)->first();

                if($cekLaporan > 0){
                    $dataP[] = array(
                        'id_pengajuan' => $pengajuan->id_pengajuan,
                        'status_pengajuan' => $pengajuan->status,
                        'anggaran_pengajuan' => $pengajuan->anggaran,
                        'proposal' => $pengajuan->proposal,
    
                        'anggaran' => $pengadaan->anggaran,
                        'nama_pengadaan' => $pengadaan->nama_pengadaan,
                        'gambar' => $pengadaan->gambar,
    
                        'nama_suplier' => $suplier  -> nama_usaha,
                        'email_suplier' => $suplier -> email,
                        'alamat_suplier' => $suplier-> alamat,

                        'laporan' => $laporan-> laporan,
                        'id_laporan' => $laporan-> id_laporan,
                    );

                }else{

                }

            }

            $data['pengajuan'] = $dataP;
            return view('admin.laporan', $data);
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Anda Belum Login');
        }
    }

    public function selesaiPengajuan($id){
        $token = Session::get('token');
        $tokenDB = M_Admin::where("token", $token)->count();

        if($tokenDB > 0){
            if(M_Pengajuan::where('id_pengajuan', $id)->update([
                'status' => '3'
            ])){
                return redirect('/laporan')->with('berhasil', 'Status Pengajuan Berhasil Diubah');
            }else{
                return redirect('/laporan')->with('gagal', 'Status Pengajuan Gagal Diubah!');
            }
        }else{
            return redirect('/loginAdmin')->with('gagal', 'Mohon Login Terlebih Dahulu!');
        }
    }
    
    public function pengajuanSelesai(){
        $Key = env('APP_KEY');
        //validasi session
        
        $token = Session::get('token');
        $tokenDB = M_Suplier::where('token', $token)->count();

        $decode = JWT::decode($token, new Key($Key, 'HS256'));
        $decode_array = (array) $decode;

        if($tokenDB > 0){    
            $data['sup'] = M_Suplier::where('token', $token)->first();
            $pengajuans = M_Pengajuan::where('id_suplier', $decode_array['id_suplier'])->where('status', '3')->get();             
            $dataArr = array();

            foreach($pengajuans as $pengajuan){
                $pengadaan = M_Pengadaan::where('id_pengadaan', $pengajuan -> id_pengadaan)->first();
                $suplier = M_Suplier::where('id_suplier', $decode_array['id_suplier'])->first();

                $lapCount = M_Laporan::where('id_pengajuan', $pengajuan -> id_pengajuan)->count();
                $lap = M_Laporan::where('id_pengajuan', $pengajuan -> id_pengajuan)->first();

                if($lapCount > 0){
                    $lapLink = $lap->laporan;
                }else{
                    $lapLink = "-";
                }

                $dataArr[] = array(
                    'id_pengajuan' => $pengajuan->id_pengajuan,
                    'status_pengajuan' => $pengajuan->status,
                    'anggaran_pengajuan' => $pengajuan->anggaran,
                    'proposal' => $pengajuan->proposal,

                    'anggaran' => $pengadaan->anggaran,
                    'nama_pengadaan' => $pengadaan->nama_pengadaan,
                    'gambar' => $pengadaan->gambar,

                    'nama_suplier' => $suplier  -> nama_usaha,
                    'email_suplier' => $suplier -> email,
                    'alamat_suplier' => $suplier-> alamat,

                    'laporan' => $lapLink,
                );
            }

            $data['pengajuan'] = $dataArr;
            return view('suplier.pengajuanSelesai', $data);
            
        }else{
            return redirect('/listSuplier')->with('gagal', 'Mohon Login Terlebih Dahulu!');
         }
    }
}
