<?php

namespace App\Http\Controllers\Api;

use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get divisi
        $divisis = Divisi::oldest()->paginate(10);

        // return list divisi
        return new PostResource(true,'List Divisi', $divisis);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'required',
            'gambar'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('gambar');
        $image->storeAs('public/divisi', $image->hashName());

        //create post
        $divisi = Divisi::create([
            'gambar'     => $image->hashName(),
            'nama_divisi' => $request->nama_divisi
        ]);

        //return response
        return new PostResource(true, 'Divisi Berhasil Ditambahkan!', $divisi);
    }

    /**
     * Display the specified resource.
     */
    public function show(Divisi $divisi)
    {
        //
        return new PostResource(true, 'Data Divisi Ditemukan!', $divisi);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Divisi $divisi)
    {
         //define validation rules
        $validator = Validator::make($request->all(), [
            'gambar'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_divisi' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('gambar')) {

            //upload image
            $image = $request->file('gambar');
            $image->storeAs('public/divisi', $image->hashName());

            //delete old image
            Storage::delete('public/divisi/'.$divisi->image);

            //update post with new image
            $divisi->update([
                'gambar'     => $image->hashName(),
                'nama_divisi' => $request->nama_divisi
            ]);

        } else {

            //update post without image
            $divisi->update([
            'nama_divisi'  => $request->nama_divisi
            ]);
        }

        //return response
        return new PostResource(true, 'Data Divisi Berhasil Diubah!', $divisi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Divisi $divisi)
    {
         //delete image
         Storage::delete('public/divisi/'.$divisi->image);

         //delete post
         $divisi->delete();
 
         //return response
         return new PostResource(true, 'Data Divisi Berhasil Dihapus!', null);
    }
}
