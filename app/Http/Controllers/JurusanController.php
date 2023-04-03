<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\jurusan;

class JurusanController extends Controller
{
    public function getjurusan()
    {
        $dt_jurusan=jurusan::get();
        return response()->json($dt_jurusan);
    }
    
    public function getid_jurusan($id_jurusan)
    {
        $dt_jurusan=jurusan::where('id_jurusan','=', $id_jurusan)->get();
        return response()->json($dt_jurusan);
    }

    public function createjurusan(request $req){
        $validate = Validator::make($req->all(),[
            'nama_jurusan'=>'required'
        ]);
        if($validate->fails()){
            return response()->json($validate->errors()->tojson());
        }
        $create = Jurusan::create([
            'nama_jurusan'=>$req->nama_jurusan
        ]);
        if($create){
            return response()->json(['status'=>true, 'message'=>'Sukses menambahkan data jurusan.']);
        }else{
            return response()->json(['status'=>false, 'message'=>'Gagal menambahkan data jurusan.']);
        }
    }

    public function deletejurusan($id_jurusan){
        $delete = jurusan::where('id_jurusan',$id_jurusan)->delete();
        if($delete){
            return response()->json(['status'=>true, 'message'=>'Sukses menghapus data jurusan.']);
        }else{
            return response()->json(['status'=>false, 'message'=>'Gagal menghapus data jurusan.']);
        }
    }

    public function updatejurusan(Request $req, $id_jurusan){
        $validate = Validator::make($req->all(),[
            'nama_jurusan'=>'required'
        ]);
        if($validate->fails()){
            return response()->json($validate->errors()->toJson());
        }
        $update = jurusan::where('id_jurusan',$id_jurusan)->update([
            'nama_jurusan'=>$req->get('nama_jurusan')
            
        ]);
        if($update){
            return response()->json(['status'=>true,  'message'=>'Berhasil mengubah data jurusan']);
        }else{
            return response()->json(['status'=>false, 'message'=>'Gagal mengubah data jurusan']);
        }
    }
}
