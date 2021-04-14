<?php

namespace App\Http\Controllers;

use App\Models\usersdepartemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function AddDepart(Request $request){
        if($validate = $this->validasi($request->all(),[
            'token' => 'required',
            'departemen' => 'required',
        ]))
            return $validate;

        $user = usersdepartemen::create($request->toArray());
        return $this->resSuccess($user);
    }

    public function AllDepart(){
        return $this->resSuccess(usersdepartemen::all());
    }
}
