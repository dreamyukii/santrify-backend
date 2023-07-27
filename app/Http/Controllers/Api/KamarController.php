<?php

namespace App\Http\Controllers\Api;
use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get Kamar
        $kamars = Kamar::oldest()->paginate(10);

        // return list kamar
        return new PostResource(true,'List Kamars', $kamars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //define validation rules
         $validator = Validator::make($request->all(), [
            'nama_kamar' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/kamar', $image->hashName());

        //create post
        $kamar = Kamar::create([
            'image'     => $image->hashName(),
            'nama_kamar' => $request->nama_kamar,
            'status'      => $request->status
        ]);

        //return response
        return new PostResource(true, 'Kamar Berhasil Ditambahkan!', $kamar);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kamar $kamar)
    {
        return new PostResource(true, 'Data Kamar Ditemukan!', $kamar);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kamar $kamar)
    {
                 //define validation rules
                 $validator = Validator::make($request->all(), [
                    'nama_kamar' => 'required',
                    'status' => 'required',
                    'image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);
        
                //check if validation fails
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }
        
                //check if image is not empty
                if ($request->hasFile('image')) {
        
                    //upload image
                    $image = $request->file('image');
                    $image->storeAs('public/kamar', $image->hashName());
        
                    //delete old image
                    Storage::delete('public/kamar'.$kamar->image);
        
                    //update post with new image
                    $kamar->update([
                        'image'     => $image->hashName(),
                        'nama_kamar'   => $request->nama_kamar,
                        'status'   => $request->status
                    ]);
        
                } else {
        
                    //update post without image
                    $kamar->update([
                    'nama_kamar'   => $request->nama_divisi,
                    'status'   => $request->status
                    ]);
                }
        
                //return response
                return new PostResource(true, 'Data Kamar Berhasil Diubah!', $kamar);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kamar $kamar)
    {
        //delete image
        Storage::delete('public/kamar/'.$kamar->image);

        //delete kamar
        $kamar->delete();

        //return response
        return new PostResource(true, 'Data kamar Berhasil Dihapus!', null);
   }
    }
