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
use App\Models\Hafalan_Detail;
use App\Models\Kelas;
use App\Models\User;


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
      $isExixts = Murid::where('id_kelas', $datauser['id_kelas'])->get();
      

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

    public function daftarHafalanFilter($id_murid, $status)
    {
      $isExixts = Hafalan_Detail::where('id_murid', $id_murid)->where('status', $status)->get();

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
    $datamurid = Murid::where('id_kelas', $id_kelas)->get();

    $request->validate([
        'surah' => 'required',
        'juz' => 'required',
        'ayat' => 'required',
    ]);

    $random = Str::random(10);
    $response = [];

    $hafalan = Hafalan::create([
      'surah' => $request->surah,
      'juz' => $request->juz,
      'ayat' => $request->ayat,
      'id_kelas' => $id_kelas,
      'id_input' => $random,
  ]);

    foreach ($datamurid as $r) {
        $hafalan = Hafalan_detail::create([
            'surah' => $request->surah,
            'juz' => $request->juz,
            'ayat' => $request->ayat,
            'status' => 0,
            'id_kelas' => $id_kelas,
            'id_murid' => $r['id'],
            'id_input' => $random,
        ]);

        

        if (!$hafalan) {
            $response[] = [
                'status' => 'failed',
                'message' => 'Cannot create data for murid ID: ' . $r['id'],
            ];
            break; // Menghentikan loop jika terjadi kesalahan
        }
    }

    if (!empty($response)) {
        return response()->json($response, 400);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Data created successfully',
    ], 200);
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
            // 'created_at' => time(),
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
            // 'created_at' => time(),
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

     public function kelas($id)
    {
      $isExixts = Kelas::find($id);

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

    public function updateGuru(Request $request, $id)
    {
        $guru = User::find($id);

        if(!$guru) {
           return response()->json([
             'message' => 'Data cannot find',
             'status' => 400,
           ]);
         }

         $request->validate([
            'email' => 'required',
            'username' => 'required',
            'nama_lengkap' => 'required',
            'ttl' => 'required',
        ]);

         

         $data = $guru->update([
           'email' => $request->email,
           'username' => $request->username,
           'nama_lengkap' => $request->nama_lengkap,
           'ttl' => $request->ttl,
           //$kelas->updated_at => time(),
         ]);

         if (!$data) {
           return response()->json([
             'message' => 'Data cannot updated',
             'status' => 400,
           ]);
         } else {
           return response()->json([
             'message' => 'Data successfully updated',
             'data' => $data,
             'status' => 200,
           ]);
         }
        
    }

    public function dataHafalanKelas($id_kelas)
    {
      $isExixts = Hafalan::where('id_kelas', $id_kelas)->get();

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

    public function detailTilawah($id)
    {
      $tilawah = Tilawah::find($id);
    
      if(!$tilawah){
        return response()->json([
          'message' => 'Data Empty',
          'status' => 400
        ]);
      }

      return response()->json([
        'message' => 'Get successfully',
        'data' => $tilawah,
        'status' => 200,
      ]);
    }

    public function detailMurojaah($id)
    {
      $tilawah = Murojaah::find($id);
    
      if(!$tilawah){
        return response()->json([
          'message' => 'Data Empty',
          'status' => 400
        ]);
      }

      return response()->json([
        'message' => 'Get successfully',
        'data' => $tilawah,
        'status' => 200,
      ]);
    }

    public function dataMurid($id)
    {
      $isExixts = Murid::find($id);

      if(!$isExixts){
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

    public function dataOrtu($id)
    {
      $isExixts = User::where('id_murid', $id)->first();

      if(!$isExixts){
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

    public function destroyAllHafalan($id_input)
    {
        $hafalan = Hafalan::where('id_input', $id_input);
        $hafalan->delete();

        $hafalan2 = Hafalan_detail::where('id_input', $id_input);
        $hafalan2->delete();

        return response()->json([
          'message' => 'delete successfully',
          'status' => 200
        ]);
    }

    public function dataHafalanDetail($id_kelas)
    {
      $isExixts = Hafalan::where('id_kelas', $id_kelas)->get();

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

    public function updateHafalan(Request $request, $id_input)
    {

      $datauser = $this->guard()->user();
        // $hafalan = Hafalan::find($id);
      $hafalan = Hafalan_detail::where('id_input', $id_input)->get();
      $hafalan2 = Hafalan::where('id_input', $id_input)->first();

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
          ]);


        //   Hafalan::updated([
        //     'surah' => $request->surah,
        //     'juz' => $request->juz,
        //     'ayat' => $request->ayat,
        // ]);

        $hafalan2->surah = $request->surah;
        $hafalan2->juz = $request->juz;
        $hafalan2->ayat = $request->ayat;
        $hafalan2->id_kelas = $datauser->id_kelas;
        $hafalan2->save();

         foreach($hafalan as $r) {

          // $data = $hafalan->update([
            $r->surah = $request->surah;
            $r->juz = $request->juz;
            $r->ayat = $request->ayat;
            $r->status = 0;
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

    public function updateStatusHafalan($id)
    {
      $isExixts = Hafalan_Detail::find($id);

      if(!$isExixts){
         return response()->json([
          'message' => 'Data cannot updated',
          'status' => 400,
        ]);
      } 
      $isExixts->update(['status' => '1']);
      return response()->json([
        'message' => 'Data successfully updated',
        'status' => 200,
      ]); 
    }

    public function dataHafalan($id)
    {
      $isExixts = Hafalan::find($id);

      if(!$isExixts){
         return response()->json([
          'message' => 'Data cannot updated',
          'status' => 400,
        ]);
      } 
      return response()->json([
        'message' => 'Data successfully updated',
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
