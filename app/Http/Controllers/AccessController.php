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

        $access = usersacces::create($request->toArray());
        return $this->resSuccess($access);
    }
}
