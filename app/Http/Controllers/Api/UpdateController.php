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
        $user = User::where('id', $userId['id'])->first();

        //define validation rules
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/users', $image->hashName());

            // delete image
            Storage::delete('public/users/'.$user->image);

            //update user with new image
            $user->update([
                'image'  => $image->hashName(),
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'email' => $request->email,
            ]);

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
            'success' => true,
            'message' => 'Data User berhasil diubah!',
        ]);
    }
}