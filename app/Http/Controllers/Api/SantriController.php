<?php

namespace App\Http\Controllers\Api;

use App\Models\Santri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SantriController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $santris = Santri::latest()->paginate(10);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Santri', $santris);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [

            'nama' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'room' => 'required',
            'division' => 'required',
            'gambar'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('gambar');
        $image->storeAs('public/santri', $image->hashName());

        //create post
        $santri = Santri::create([
            'gambar'     => $image->hashName(),
            'nama'      => $request->nama,
            'gender'    => $request->gender,
            'status'    => $request->status,
            'room'      => $request->room,
            'division'   => $request->division
        ]);

        //return response
        return new PostResource(true, 'Santri Berhasil Ditambahkan!', $santri);
    }


    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(Santri $santri)
    {
        //return single post as a resource
        return new PostResource(true, 'Data Santri Ditemukan!', $santri);
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Santri $santri)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'gambar'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'room' => 'required',
            'division' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('gambar')) {

            //upload image
            $image = $request->file('gambar');
            $image->storeAs('public/santri', $image->hashName());

            //delete old image
            Storage::delete('public/santri/'.$santri->image);

            //update post with new image
            $santri->update([
                'gambar'     => $image->hashName(),
                'nama'      => $request->nama,
                'gender'    => $request->gender,
                'status'    => $request->status,
                'room'      => $request->room,
                'division'   => $request->division
                
            ]);

        } else {

            //update post without image
            $santri->update([
            
            'nama'      => $request->nama,
            'gender'    => $request->gender,
            'status'    => $request->status,
            'room'      => $request->room,
            'division'   => $request->division
            ]);
        }

        //return response
        return new PostResource(true, 'Data Santri Berhasil Diubah!', $santri);
    }
    
    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy(Santri $santri)
    {
        //delete image
        Storage::delete('public/santri/'.$santri->image);

        //delete post
        $santri->delete();

        //return response
        return new PostResource(true, 'Data Santri Berhasil Dihapus!', null);
    }
}