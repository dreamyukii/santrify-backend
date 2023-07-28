<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Http\Resources\PostResource;


class DashboardController extends Controller
{
    //
    public function index(){
        $totaldana = Santri::sum('bill');

        return new PostResource(true,'Total Dana', $totaldana);
    }
}
