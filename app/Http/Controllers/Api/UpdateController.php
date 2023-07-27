<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $userId = auth()->guard('api')->user();
        $user = User::where('id', $userId['id']);
        
        //define validation rules
        $validator = Validator::make($request->all(), [
            'gambar'     => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $gambar = null;
        //check if image is not empty
        if ($request->hasFile('gambar')) {

            //upload image
            $image = $request->file('gambar');
            $image->storeAs('public/users', $image->hashName());

            //update user with new image
            $user->update([
                'gambar'     => $image->hashName(),
                'name'      => $request->name,
                'password' => Hash::make($request->password),
                'email'    => $request->email,
            ]);

            // g bisa delete bang
            Storage::delete('public/users/'.$user->image);

        } else {
            //update post without image
            $user->update([
            
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }
        //return response
        return response()->json([
            'success'=>true,
            'message' => 'Data User berhasil diubah!',
        ]);
    }
}
