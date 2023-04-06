<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\carbon;

class PeminjamanController extends Controller
{
    public function getpeminjaman(Request $req)
    {
        $data_peminjaman=peminjaman::
        join('mahasiswa','mahasiswa.id','=','peminjaman.id')
        ->join('jurusan','jurusan.id_jurusan','=','peminjaman.id_jurusan')
        ->join('buku','buku.id_buku','=','peminjaman.id_buku')
        ->get();
      return Response()->json($data_peminjaman);
    }

    public function getid_peminjaman($id_peminjaman)
    {
        $dt_mahasiswa=peminjaman::where('id_peminjaman','=', $id_peminjaman)
        ->join('mahasiswa','mahasiswa.id','=','peminjaman.id')
        ->join('jurusan','jurusan.id_jurusan','=','peminjaman.id_jurusan')
        ->join('buku','buku.id_buku','=','peminjaman.id_buku')
        ->get();
        return response()->json($dt_mahasiswa);
    }

    public function createpeminjaman(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'id'=>'required',
            'id_jurusan'=>'required',
            'id_buku'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $tenggat = carbon::now()->addDays(4);
        $save = peminjaman::create([
            'id' =>$req->get('id'),
            'id_jurusan' =>$req->get('id_jurusan'),
            'id_buku' =>$req->get('id_buku'),
            'tgl_peminjaman' =>date('Y-m-d H:i:s'),
            'tgl_kembali' =>date('Y-m-d H:i:s'),
            'tenggat' =>$tenggat,
            'status' => 'Dipinjam'
        ]);
        if($save){
            return Response()->json(['status'=>true,'message' => 'Sukses Menambah Peminjaman']);
        } else {
            return Response()->json(['status'=>false,'message' => 'Gagal Menambah Peminjaman']);
        }
    }

    public function updatepeminjaman(Request $req, $id_peminjaman){
        $validate = Validator::make($req->all(),[
            'id'=>'required',
            'id_jurusan'=>'required',
            'id_buku'=>'required'
    
        ]);
        if($validate->fails()){
            return response()->json($validate->errors()->toJson());
        }
        $update = peminjaman::where('id_peminjaman',$id_peminjaman)->update([
            'id'=>$req->get('id'),
            'id_jurusan'=>$req->get('id_jurusan'),
            'id_buku'=>$req->get('id_buku'),
            'tgl_kembali'=>$req->get('tgl_kembali'),
            'status'=>$req->get('status')
            
        ]);
        if($update){
            return response()->json(['status'=>true,  'message'=>'Berhasil mengubah data Peminjaman']);
        }else{
            return response()->json(['status'=>false, 'message'=>'Gagal mengubah data Peminjaman']);
        }
    }

    public function deletepeminjaman($id_peminjaman){
        $delete = peminjaman::where('id_peminjaman',$id_peminjaman)->delete();
        if($delete){
            return response()->json(['status'=>true, 'message'=>'Sukses menghapus data Peminjaman.']);
        }else{
            return response()->json(['status'=>false, 'message'=>'Gagal menghapus data Peminjaman.']);
        }
    }
}
