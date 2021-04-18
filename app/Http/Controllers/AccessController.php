<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\usersacces;
use Illuminate\Http\Request;

class AccessController extends Controller
{


    public function AddAccess(Request $request){
        if($validate = $this->validasi($request->all(),[
            'access' => 'required',
        ]))
            return $validate;
        
        $check = usersacces::where('access', $request->access)->first();
        if($check){
            return $this->resFailure(1,"Users Access Sudah Didaftarkan");
        }
        $access = usersacces::create($request->toArray());
        return $this->resSuccess($access);
    }

    public function deleteAccess(Request $request){
        $cari = usersacces::where('id', $request->id)->first();
        $cari->delete();
        return $this->resFailure(0,"Access Berhasil Dihapus");
    }
}
