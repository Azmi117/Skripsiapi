<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;

use App\Models\Murid;
use App\Models\Murojaah;
use App\Models\Tilawah;
use App\Models\Hafalan;


use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function profile()
    {
        return response()->json($this->guard()->user());
    }

    public function daftarMurid()
    {
      $datauser = $this->guard()->user();
      $isExixts = Murid::where('id_kelas', $datauser['id_kelas'])->exists();
      

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

    public function dataHafalanMurid($id_murid)
    {
      $isExixts = Hafalan::where('id_murid', $id_murid)->exists();

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

    public function daftarHafalanFilter($id_murid,$status)
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

    public function tambahHafalan(Request $request)
    {

        $id_kelas = Auth::user()->id_kelas;
        //$datauser = response()->json($this->guard()->user());
        //$datauservar = json_decode($datauser);

        $datamurid = Murid::where('id_kelas', $id_kelas)->get();


        $request->validate([
            'surah' => 'required',
            'juz' => 'required',
            'ayat' => 'required',
        ]);
        
        $random = Str::random(10);
        foreach($datamurid as $r) {

            $hafalan = Hafalan::create([
                'surah' => $request->surah,
                'juz' => $request->juz,
                'ayat' => $request->ayat,
                'status' => 0,
                'id_kelas' => $id_kelas,
                'id_murid' => $r['id'],
                // 'created_at' => time(),
                'id_input' => $random,
    
            ]);   

        }

        if ($hafalan) {
          return response()->json([
            'status' => 'success',
            'message' => 'Data created successfully',
            ],
            200);
        } else {
          return response()->json([
            'status' => 'failed',
            'message' => 'Cannot created data'
          ], 400);
        }
    }

    public function updateHafalan(Request $request, $id_input)
    {

      //$datauser = $this->guard()->user();
        // $hafalan = Hafalan::find($id);
      $hafalan = Hafalan::where('id_input', $id_input)->get();

        if(!$hafalan) {
           return response()->json([
             'message' => 'Data cannot find',
             'status' => 400,
           ]);
         }

           $validate = $request->validate([
             'surah' => 'required',
             'juz' => 'required',
             'ayat' => 'required',
             'status' => 'required',
          ]);


         foreach($hafalan as $r) {

          // $data = $hafalan->update([
            $r->surah = $request->surah;
            $r->juz = $request->juz;
            $r->ayat = $request->ayat;
            $r->status = $request->status;
            $r->save();
            //$hafalan->id_kelas => $datauser['id_kelas'],
            //$hafalan->updated_at => time(),
          // ]);
          

      }

      if (!$r) {
        return response()->json([
          'message' => 'Data cannot updated',
          'status' => 400,
        ]);
      } else {
        return response()->json([
          'message' => 'Data successfully updated',
          'status' => 200,
        ]);
      }
        
    }

    public function destroyHafalan($id)
    {
        $hafalan = Hafalan::find($id);
        $hafalan->delete();

        return response()->json([
          'message' => 'delete successfully',
          'status' => 200
        ]);
    }

    

    public function dataTilawah()
    {
      $tilawah = Tilawah::all();

      if (!$tilawah) {
        return response()->json([
          'message' => 'Failed or Empty data',
          'status' => 400,
        ]);
      }

      return response()->json([
        'message' => 'Success',
        'status' => 200,
        'data' => $tilawah
      ]);
    }

    public function tambahTilawah(Request $request)
    {

        $datauser = $this->guard()->user();

        $request->validate([
            'surah' => 'required',
            'juz' => 'required',
            'ayat' => 'required',
        ]);


        $tilawah = Tilawah::create([
            'surah' => $request->surah,
            'juz' => $request->juz,
            'ayat' => $request->ayat,
            'id_kelas' => $datauser['id_kelas'],
            'created_at' => time(),

        ]);

        if ($tilawah) {
          return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            ],
            200);
        } else {
          return response()->json([
            'status' => 'failed',
            'message' => 'Cannot created data'
          ], 400);
        }
    }

    public function updateTilawah(Request $request, $id)
    {
        $tilawah = Tilawah::find($id);

        if(!$tilawah) {
           return response()->json([
             'message' => 'Data cannot find',
             'status' => 400,
           ]);
         }

         $request->validate([
            'surah' => 'required',
            'juz' => 'required',
            'ayat' => 'required',
        ]);

         

         $data = $tilawah->update([
           "surah" => $request->surah,
           "juz" => $request->juz,
           "ayat" => $request->ayat,
           //$tilawah->updated_at => time(),
         ]);

         if (!$data) {
           return response()->json([
             'message' => 'Data cannot updated',
             'status' => 400,
           ]);
         } else {
           return response()->json([
             'message' => 'Data successfully updated',
             'status' => 200,
             'data' => $tilawah,
           ]);
         }
        
    }

    public function destroyTilawah($id)
    {
        $tilawah = Tilawah::find($id);
        $tilawah->delete();

        return response()->json([
          'message' => 'delete successfully',
          'status' => 200
        ]);
    }

    public function dataMurojaah()
    {
      $murojaah = Murojaah::all();

      if (!$murojaah) {
        return response()->json([
          'message' => 'Failed or Empty data',
          'status' => 400,
        ]);
      }

      return response()->json([
        'message' => 'Success',
        'status' => 200,
        'data' => $murojaah
      ]);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function tambahMurojaah(Request $request)
    {

        
      
        $datauser = Auth::user();

        $user = JWTAuth::parseToken()->toUser();

        $request->validate([
            'surah' => 'required',
            'juz' => 'required',
            'ayat' => 'required',
        ]);


        $murojaah = Murojaah::create([
            'surah' => $request->surah,
            'juz' => $request->juz,
            'ayat' => $request->ayat,
            'id_kelas' => $user->id_kelas,
            'created_at' => time(),

        ]);

        if ($murojaah) {
          return response()->json([
            'status' => 'success',
            'message' => 'Data created successfully',
            ],
            200);
        } else {
          return response()->json([
            'status' => 'failed',
            'message' => 'Cannot created data'
          ], 400);
        }
    }

    public function updateMurojaah(Request $request, $id)
    {
        $murojaah = Murojaah::find($id);

        if(!$murojaah) {
           return response()->json([
             'message' => 'Data cannot find',
             'status' => 400,
           ]);
         }

         $request->validate([
            'surah' => 'required',
            'juz' => 'required',
            'ayat' => 'required',
        ]);

         

         $data = $murojaah->update([
           "surah" => $request->surah,
           "juz" => $request->juz,
           "ayat" => $request->ayat,
           //$tilawah->updated_at => time(),
    
         ]);

         if (!$data) {
           return response()->json([
             'message' => 'Data cannot updated',
             'status' => 400,
           ]);
         } else {
           return response()->json([
             'message' => 'Data successfully updated',
             'status' => 200,
             'data' => $murojaah,
           ]);
         }
        
    }

    public function destroyMurojaah($id)
    {
        $murojaah = Murojaah::find($id);
        $murojaah->delete();

        return response()->json([
          'message' => 'delete successfully',
          'status' => 200
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
