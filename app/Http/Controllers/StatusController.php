<?php

namespace App\Http\Controllers;

use App\Models\usersacces;
use App\Models\usersdetail;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function AddStatus(Request $request){
        if($validate = $this->validasi($request->all(),[
            'token' => 'required',
            'user_id' => 'required',
            'motto' => 'required',
            'alamat' => 'required',
        ]))
            return $validate;

        $user = usersdetail::create($request->toArray());
        return $this->resSuccess($user);
    }

    public function UpdateStatus(Request $request){
        if($validate = $this->validasi($request->all(),[
            'token' => 'required',
            'user_id' => 'required'
        ]))
            return $validate;

        $user = usersdetail::find($request->user_id);
        if (!is_null($request->alamat)) $user->alamat = $request->alamat;
        if (!is_null($request->motto)) $user->motto = $request->motto;
        if (!is_null($request->pekerjaan)) $user->pekerjaan = $request->pekerjaan;
        if (!is_null($request->pendidikan)) $user->pendidikan = $request->pendidikan;
        if (!is_null($request->contact)) $user->contact = $request->contact;
        if (!is_null($request->sosmed)) $user->sosmed = $request->sosmed;
        if (!is_null($request->departemen_id)) $user->departemen_id = $request->departemen_id;
        $user->update();
        return $this->resSuccess($user);
    }

}
