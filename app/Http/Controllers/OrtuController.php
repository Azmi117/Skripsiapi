<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Murid;
use App\Models\Murojaah;
use App\Models\Tilawah;
use App\Models\Hafalan;


use Illuminate\Http\Request;

class OrtuController extends Controller
{
    public function profile()
    {
        return response()->json($this->guard()->user());
    }

    public function dataMurid()
    {
      $datauser = $this->guard()->user();
      $isExixts = Murid::where('id_murid', $datauser['id_murid'])->exists();
      

      if (!$isExixts) {
        return response()->json([
          'message' => 'Data Empty',
          'status' => 400
        ]);
      }


      return response()->json([
        'message' => 'Get successfully',
        'data' => $isExixts,
        'status' => 200,
      ]);
    }

    public function dataHafalanFilter($id_murid,$status)
    {
      $isExixts = Hafalan::where('id_murid', $id_murid && 'status', $status)->exists();

      if (!$isExixts) {
        return response()->json([
          'message' => 'Data Empty',
          'status' => 400
        ]);
      }


      return response()->json([
        'message' => 'Get successfully',
        'data' => $isExixts,
        'status' => 200,
      ]);
    }

    public function dataMurojaah()
    {
      $datauser = $this->guard()->user();
        $isExixts = Murojaah::where('id_kelas', $datauser['id_kelas'])->exists();

        if (!$isExixts) {
          return response()->json([
            'message' => 'Data Empty',
            'status' => 400
          ]);
        }
  
  
        return response()->json([
          'message' => 'Get successfully',
          'data' => $isExixts,
          'status' => 200,
        ]);
    }

    public function dataTilawah()
    {
      $datauser = $this->guard()->user();
        $isExixts = Tilawah::where('id_kelas', $datauser['id_kelas'])->exists();

        if (!$isExixts) {
          return response()->json([
            'message' => 'Data Empty',
            'status' => 400
          ]);
        }
  
  
        return response()->json([
          'message' => 'Get successfully',
          'data' => $isExixts,
          'status' => 200,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }


}
