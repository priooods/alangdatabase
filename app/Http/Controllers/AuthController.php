<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\usersacces;
use App\Models\usersdepartemen;
use App\Models\usersdetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['Login','Register','findallUser','Updated','findallTamu']]);
    }

    public function Register(Request $request){
        if($validate = $this->validasi($request->all(),[
            'name' => 'required',
            'fullname' => 'required',
            'gender' => 'required|in:Pria,Wanita',
            'password' => 'required'
        ]))
            return $validate;

            $request['password_verif'] = Crypt::encrypt($request['password']);
            $request['password'] = Hash::make($request['password']);
            $request['log'] = 0;
            $user = User::create($request->toArray());
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $user->id . '_' . $file->getClientOriginalName();
                $path = $file->move(public_path('images/user'), $filename);
                $user->update(['avatar' => $filename]);
            }
            return $this->resUsers($user);
    }

    public function Login(Request $request){
        if($validate = $this->validasi($request->all(),[
            'name' => 'required',
            'password' => 'required'
        ]))
            return $validate;

        $credential = request(['name', 'password']);
        if (!$token = Auth::attempt($credential)) {
            return response()->json([
                'error_code' => 1,
                'error_message' => 'Akun kamu tidak ditemukan, pastikan kamu memasukan informasi dengan benar.'
            ]);
        }

        $user = User::where('name', $request->name)->first();
        $user->log = 1;
        $user->update();
        return response()->json([
                'error_code' => 0,
                'error_message' => '',
                'token' => $token
            ]);
    }

    public function me(){
        $user = Auth::user();
        $user->access;
        if($user->type == 'Tamu'){
            if($user->detailtamu != null){
                $user->detailtamu;
            }
        } else {
            if($user->detail != null){
                $user->departemen = usersdepartemen::find($user->detail->departemen_id);
            }
            $user->detail;
        }
        return $this->resUsers($user);
    }

    public function Updated(Request $request){
        if ($validate = $this->validasi($request->all(),[
            'id' => 'required',
        ]))
            return $validate;

        $user = User::where('id',$request->id)->first();
        if ($request->avatar != null){
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $user->id . '_' . $file->getClientOriginalName();
                if ($user->avatar) {
                    $file_loc = public_path('images/user/') . $user->avatar;
                    unlink($file_loc);
                }
                $path = $file->move(public_path('images/user'), $filename);
                $user->avatar = $request->avatar = $filename;
            }
        }
        if (!is_null($request->password)) $user->password_verified = Crypt::encrypt($request->password);
        if (!is_null($request->fullname)) $user->fullname = $request->fullname;
        if (!is_null($request->password)) $user->password = Hash::make($request->password);
        if (!is_null($request->name)) $user->name = $request->name;
        if (!is_null($request->type)) $user->type = $request->type;
        if (!is_null($request->access_id)) $user->access_id = $request->access_id;
        if (!is_null($request->gender)) $user->gender = $request->gender;
        if (!is_null($request->alamat)) $user->alamat = $request->alamat;
        $user->update();
        return $this->resUsers($user);
    }

    public function Logout(){
        $us = Auth::user();
        $user = User::where('id', $us->id)->first();
        $user->update(['log' => 0]);
        Auth::logout();
        return $this->resSuccess("Kamu berhasil keluar dari applikasi ! Happy nice day");
    }

    public function findallUser(){
        $user = User::where('type', 'Pengguna')->with(['access','detail' => function($q){
                $q->with('department');
            }
        ])->get();
        foreach($user as $us){
            $us->password_verif = Crypt::decrypt($us->password_verif); 
        }
        return $this->resSuccess($user);
    }

    public function findallTamu(){
        $user = User::where('type', 'Tamu')->with(['access','detailtamu'])->get();
        foreach($user as $us){
            $us->password_verif = Crypt::decrypt($us->password_verif); 
        }
        return $this->resSuccess($user);
    }

}
