<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\buku;

class BukuController extends Controller
{
    public function getbuku()
    {
        $dt_buku=buku::get();
        return response()->json($dt_buku);
    }
    
    public function getid_buku($id_buku)
    {
        $dt_buku=buku::where('id_buku','=', $id_buku)->get();
        return response()->json($dt_buku);
    }

    public function createbuku(request $req){
        $validate = Validator::make($req->all(),[
            'judul_buku'=>'required',
            'jenis_buku'=>'required',
            'pengarang'=>'required'
        ]);
        if($validate->fails()){
            return response()->json($validate->errors()->tojson());
        }
        $create = Buku::create([
            'judul_buku'=>$req->judul_buku,
            'jenis_buku'=>$req->jenis_buku,
            'pengarang'=>$req->pengarang
        ]);
        if($create){
            return response()->json(['status'=>true, 'message'=>'Sukses menambahkan data buku.']);
        }else{
            return response()->json(['status'=>false, 'message'=>'Gagal menambahkan data buku.']);
        }
    }

    public function deletebuku($id_buku){
        $delete = buku::where('id_buku',$id_buku)->delete();
        if($delete){
            return response()->json(['status'=>true, 'message'=>'Sukses menghapus data buku.']);
        }else{
            return response()->json(['status'=>false, 'message'=>'Gagal menghapus data buku.']);
        }
    }

    public function updatebuku(Request $req, $id_buku){
        $validate = Validator::make($req->all(),[
            'judul_buku'=>'required',
            'jenis_buku'=>'required',
            'pengarang'=>'required'
        ]);
        if($validate->fails()){
            return response()->json($validate->errors()->toJson());
        }
        $update = buku::where('id_buku',$id_buku)->update([
            'judul_buku'=>$req->get('judul_buku'),
            'jenis_buku'=>$req->get('jenis_buku'),
            'pengarang'=>$req->get('pengarang')            
        ]);
        if($update){
            return response()->json(['status'=>true,  'message'=>'Berhasil mengubah data buku']);
        }else{
            return response()->json(['status'=>false, 'message'=>'Gagal mengubah data buku']);
        }
    }
}
