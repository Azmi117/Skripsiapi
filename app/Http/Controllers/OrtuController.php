<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Murid;
use App\Models\Murojaah;
use App\Models\Tilawah;
use App\Models\Hafalan;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;

class OrtuController extends Controller
{
    public function profile()
    {
      $datauser = $this->guard()->user();
      $ortu = User::where('id', $datauser['id'])->get();

      if (!$ortu) {
        return response()->json([
          'message' => 'Failed or Empty data',
          'status' => 400,
        ]);
      }

      return response()->json([
        'message' => 'Success',
        'status' => 200,
        'data' => $ortu
      ]);

        //return response()->json($this->guard()->user());
    }

    public function dataMurid()
    {
      $datauser = $this->guard()->user();
      $isExixts = Murid::where('id', $datauser['id_murid'])->get();
      

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
      $isExixts = Hafalan::where('id_murid', $id_murid)->where('status', $status)->get();
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

    public function dataMurojaah($data)
    {
      // $datauser = $this->guard()->user();
        //  $murid = Murid::where('id', $datauser->id_murid)->get();
         $murojaah = Murojaah::where('id_kelas', $data)->get();

        if (!$murojaah) {
          return response()->json([
            'message' => 'Data Empty',
            'status' => 400
          ]);
        }
  
  
        return response()->json([
          'message' => 'Get successfully',
          'data' => $murojaah,
          'status' => 200,
        ]);
    }

    public function dataTilawah($data)
    {
      // $datauser = $this->guard()->user();
        $isExixts = Tilawah::where('id_kelas', $data)->get();

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

    public function kelasAnak($id)
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

    public function dataGuru($id)
    {
      $isExixts = User::where('id_kelas', $id)->get();

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

    public function updateOrtu(Request $request, $id)
    {
        $ortu = User::find($id);

        if(!$ortu) {
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

         

         $data = $ortu->update([
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

    public function updateHafalan(Request $request, $id)
    {
      $hafalan = Hafalan::find($id);

      if (!$hafalan) {
          return response()->json([
              'message' => 'Data cannot find',
              'status' => 400,
          ]);
      }

      $validate = $request->validate([
          'status' => 'required',
      ]);

      $hafalan->status = $request->status;
      $hafalan->save();

      return response()->json([
          'message' => 'Data successfully updated',
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
