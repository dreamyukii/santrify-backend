<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // set validation
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'gambar'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // check if validator fails or not
        if($validator->fails()){
            return response() -> json($validator->errors(),422);
        }
        
        $image = $request->file('gambar');
        $image->storeAs('public/divisi', $image->hashName());

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gambar' => $image->hashName()
        ]);
        // return JSON response if user is created
        if($user){
            return response()->json([
                'success' => true,
                'user'=>$user,
            ],201);
        }
        // return JSON if insert is failed 
        return response()->json([
            'success' => false,
        ],409);

    }
}
