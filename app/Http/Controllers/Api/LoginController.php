<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // set validation
        $validator = Validator::make($request->all(),[
            'email' =>'required',
            'password' => 'required'
        ]);
        // if validation fails
        if($validator->fails()){
            return response() -> json($validator->errors(),422);
        }
        // get credentials
        $credentials = $request->only('email','password');
        // if auth failed
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' =>'Email atau Password anda salah!'
            ],401);
        }
        // if auth success
        return response()->json([
            'success' => true,
            'user' => auth()->guard('api')->user(),
            'token'=> $token
        ],200);
    }
}
