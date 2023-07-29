<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Santri;
use App\Models\Divisi;
use App\Http\Resources\PostResource;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $totaltagihan = Santri::sum('bill');
        $totalsantri = Santri::count();
        $totaldivisi = Kamar::count();
        $totalkamar = Kamar::count();

        $listsantri = Santri::oldest()->paginate(1000);
        $listdivisi = Kamar::oldest()->paginate(1000);
        $listkamar =  Divisi::oldest()->paginate(1000);

        return new PostResource(true, 'Data Dashboard', [
            'totaltagihan' => $totaltagihan,
            'totalsantri' => $totalsantri,
            'totaldivisi' => $totaldivisi,
            'totalkamar' => $totalkamar,

            'listsantri' => $listsantri,
            'listkamar' => $listkamar,
            'listdivisi' => $listdivisi
        ]);
    }
}