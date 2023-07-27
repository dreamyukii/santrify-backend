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
    public function index()
    {
        //get santri
        $santris = Santri::latest()->paginate(50);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Santri', $santris);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [

            'nama' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'room' => 'required',
            'divisi' => 'required',
            'image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/santri', $image->hashName());

        //create post
        $santri = Santri::create([
            'image'     => $image->hashName(),
            'nama'      => $request->nama,
            'gender'    => $request->gender,
            'status'    => $request->status,
            'room'      => $request->room,
            'divisi'   => $request->divisi
        ]);

        //return response
        return new PostResource(true, 'Santri Berhasil Ditambahkan!', $santri);
    }

    public function show(Santri $santri)
    {
        //return single post as a resource
        return new PostResource(true, 'Data Santri Ditemukan!', $santri);
    }

    public function update(Request $request, Santri $santri)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'room' => 'required',
            'divisi' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/santri', $image->hashName());

            //delete old image
            Storage::delete('public/santri/'.$santri->image);

            //update post with new image
            $santri->update([
                'image'     => $image->hashName(),
                'nama'      => $request->nama,
                'gender'    => $request->gender,
                'status'    => $request->status,
                'room'      => $request->room,
                'divisi'   => $request->divisi
                
            ]);

        } else {
            //update post without image
            $santri->update([
            'nama'      => $request->nama,
            'gender'    => $request->gender,
            'status'    => $request->status,
            'room'      => $request->room,
            'divisi'   => $request->divisi
            ]);
        }

        //return response
        return new PostResource(true, 'Data Santri Berhasil Diubah!', $santri);
    }
    
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