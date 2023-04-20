<?php

namespace App\Http\Controllers;
use App\Models\Hafalan;

use Illuminate\Http\Request;

class Test extends Controller
{
    public function index(){

        $hafalan = Hafalan::all();
        return response()->json($hafalan);


    }
}
