<?php

namespace App\Http\Controllers;

use App\Models\Proker;
use App\Models\ProkerComment;
use Illuminate\Http\Request;

class ProkerController extends Controller
{
    public function AddProker (Request $request){
        if($validate = $this->validasi($request->all(),[
            'judul'=> 'required',
            'desc'=> 'required',
            'ketua'=> 'required',
            'tgl_mulai'=> 'required',
            'department_id'=> 'required',
            'tgl_selesai'=> 'required',
            'gol_point'=> 'required',
            'lokasi'=> 'required'
        ]))
            return $validate;

        $check = Proker::where('judul', $request->judul)->first();
        if($check != null){
            return $this->resFailure(1,"Proker Yang Anda Tambahkan Sudah Ada");
        }
        $proker = new Proker();
        $proker->judul = $request->judul;
        $proker->desc = $request->desc;
        $proker->ketua = $request->ketua;
        $proker->tgl_mulai = $request->tgl_mulai;
        $proker->tgl_selesai = $request->tgl_selesai;
        $proker->lokasi = $request->lokasi;
        $proker->gol_point = $request->gol_point;
        $proker->department_id = $request->department_id;
        $proker->save();
        return $this->resSuccess($proker);
    }

    public function showProker(){
        $proker = Proker::with('department')->get();
        return $this->resSuccess($proker);
    }

    public function updateProker(Request $request){
        if($validate = $this->validasi($request->all(),[
            'judul'=> 'required',
            'desc'=> 'required',
            'ketua'=> 'required',
            'tgl_mulai'=> 'required',
            'department_id'=> 'required',
            'tgl_selesai'=> 'required',
            'gol_point'=> 'required',
            'lokasi'=> 'required'
        ]))
            return $validate;
        
        $proker = Proker::where('id', $request->id)->first();
        $proker->judul = $request->judul;
        $proker->desc = $request->desc;
        $proker->ketua = $request->ketua;
        $proker->tgl_mulai = $request->tgl_mulai;
        $proker->tgl_selesai = $request->tgl_selesai;
        $proker->lokasi = $request->lokasi;
        $proker->gol_point = $request->gol_point;
        $proker->department_id = $request->department_id;
        $proker->update();
        return $this->resSuccess($proker);
    }

    public function DeleteProker(Request $request){
        $proker = Proker::find($request->id);
        $proker->delete();
        return $this->resFailure(0,"Proker Berhasil Di Hapus");
    }

    public function ProkerKoment(Request $request){
        if($validate = $this->validasi($request->all(),[
            'komentar'=> 'required',
            'user_id'=> 'required',
        ]))
            return $validate;
        
        $koment = ProkerComment::create($request->toArray());
        $koment->userName;
        return $this->resSuccess($koment);
    }

    public function KomentarAll(){
        $koment = ProkerComment::with(['userName','prokerdetail'])->get();
        return $this->resSuccess($koment);
    }
}
