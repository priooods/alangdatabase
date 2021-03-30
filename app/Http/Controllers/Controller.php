<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function resSuccess($data){
        return response()->json([
            'error_code' => 0,
            'error_message' => "",
            'data' => $data
        ]);
    }
    public function resFailure($code,$error){
        return response()->json([
            'error_code' => $code,
            'error_message' => $error
        ]);
    }

    public function validasi($request,$items){
        $validate = Validator::make($request,$items);
        if ($validate->fails()) {
            return response()->json([
                $validate->errors()
            ],422);
        }else
            return null;
    }
}
