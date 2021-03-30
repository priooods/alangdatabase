<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['Login','Register','findall']]);
    }

    public function Register(Request $request){
        if($validate = $this->validasi($request->all(),[
            'username' => 'required',
            'fullname' => 'required',
            'alamat' => 'required',
            'access' => 'required|in:SuperUser,Admin,Sekertaris,Bendahara,Ketua,Design,Kurikulum,Hrd,Anggota',
            'gender' => 'required|in:Pria,Wanita',
            'email' => 'required',
            'password' => 'required'
        ]))
            return $validate;

        try{
            $request['password_verif'] = Crypt::encrypt($request['password']);
            $request['password'] = Hash::make($request['password']);
            $request['status'] = 0;
            $user = User::create($request->toArray());
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $user->id . '_' . $file->getClientOriginalName();
                $path = $file->move(public_path('images'), $filename);
                $user->update(['avatar' => $filename]);
            }
            return $this->resSuccess($user);
        } catch(Exception $e){
            return $this->resFailure(1, "Failure Creted New Users, Please check your access internet");
        }
    }

    public function Login(Request $request){
        if($validate = $this->validasi($request->all(),[
            'username' => 'required',
            'password' => 'required'
        ]))
            return $validate;

        if (! $token = Auth::attempt($request->toArray())) {
            return response()->json([
                'error_code' => 1,
                'error_message' => 'Users not found ! Please check again your account information'
            ]);
        }

        $user = User::where('username', $request->username)->first();
        if ($user->status) {
            $this->resFailed(1,"You must logout in anoter device first!");
        }
        $user->status = 1;
        $user->update();
        return response()->json([
                'error_code' => 0,
                'error_message' => '',
                'token' => $token
            ]);
    }

    public function me(){
        $db = Auth::user();
        $user = User::where('username', $db->username)->first();
        $user->password_verif = Crypt::decrypt($user->password_verif);
        return $this->resSuccess($user);
    }

    public function Updated(Request $request){
        if ($validate = $this->validing($request->all(),[
            'username' => 'required',
            'password' => 'required',
            'fullname' => 'required',
            'access' => 'required',
            'email' => 'required',
            'alamat' => 'required',
        ]))
            return $validate;

        $user = User::find(Auth::user()->id);
        if ($request->avatar != null){
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $user->id . '_' . $file->getClientOriginalName();
                if ($user->avatar) {
                    $file_loc = public_path('images/') . $user->avatar;
                    unlink($file_loc);
                }
                $path = $file->move(public_path('images'), $filename);
                $user->avatar = $request->avatar = $filename;
            }
        }
        if (!is_null($request->password)) $user->password_verified = Crypt::encrypt($request->password);
        if (!is_null($request->fullname)) $user->fullname = $request->fullname;
        if (!is_null($request->password)) $user->password = Hash::make($request->password);
        if (!is_null($request->username)) $user->username = $request->username;
        if (!is_null($request->access)) $user->access = $request->access;
        if (!is_null($request->gender)) $user->gender = $request->gender;
        if (!is_null($request->email)) $user->email = $request->email;
        if (!is_null($request->alamat)) $user->alamat = $request->alamat;
        $user->update();
        return $this->resSuccess($user);
    }

    public function Logout(){
        $us = Auth::user();
        $user = User::where('username', $us->username)->first();
        $user->update(['status' => 0]);
        Auth::logout();
        return $this->resSuccess("Your account successfuly logout ! Happy nice day");
    }

    public function findall(){
        return $this->resSuccess(User::all());
    }
}
