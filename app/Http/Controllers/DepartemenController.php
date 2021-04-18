<?php

namespace App\Http\Controllers;

use App\Models\usersdepartemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function AddDepart(Request $request){
        if($validate = $this->validasi($request->all(),[
            'departemen' => 'required',
        ]))
            return $validate;

        $check = usersdepartemen::where('departemen', $request->departemen)->first();
        if($check){
            return $this->resFailure(1,"Departement Sudah Didaftarkan");
        }
        $user = usersdepartemen::create($request->toArray());
        return $this->resSuccess($user);
    }

    public function AllDepart(){
        return $this->resSuccess(usersdepartemen::all());
    }
}
