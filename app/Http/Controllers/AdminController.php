<?php

namespace App\Http\Controllers;

use App\Exports\HafalanExport;
use App\Exports\Hafalan_lama_Export;
use App\Exports\Hafalan_Rumah_Export;
use App\Exports\Hafalan_Lama_Rumah_Export;
use App\Exports\Tilawah_Rumah_Export;
use App\Exports\Tilawah_Export;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\View_hafalan;
use App\Models\View_hafalan_lama;
use App\Models\View_tilawah;
use App\Models\View_hafalan_rumah;
use App\Models\View_hafalan_lama_rumah;
use App\Models\View_tilawah_rumah;



class AdminController extends Controller
{

    public function profile()
    {
        return response()->json($this->guard()->user());
    }

    public function daftarGuru()
    {
      $isExixts = User::where('level', 'Guru')->get();

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

    public function daftarOrtu()
    {
      $isExixts = User::where('level', 'Ortu')->get();

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

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
          return response()->json([
            'message' => 'product cannot show',
            'status' => 400,
          ]);
        }

        return response()->json($user, 200);
    }

    public function registerAkunOrtu(Request $request)
    {

        
        $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'nama_lengkap' => 'required',
            'password' => 'required',
            'ttl' => 'required',
            'id_murid' => 'required',
            // 'id_kelas',
        ]);


        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'password' => Hash::make($request->password),
            'level' => 'Ortu',
            'ttl' => $request->ttl,
            'id_murid' => $request->id_murid,
            // 'id_murid' => $request->id_kelas,
            // 'created_at' => time(),
        ]);



        if ($user) {
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

    public function registerAkunGuru(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'nama_lengkap' => 'required',
            'password' => 'required',
            'ttl' => 'required',
            'id_kelas' => 'required',
        ]);


        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'password' => Hash::make($request->password),
            'level' => 'guru',
            'ttl' => $request->ttl,
            'id_kelas' => $request->id_kelas,
            //'created_at' => time(),

        ]);

        if ($user) {
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
            'id_kelas' => 'required',
        ]);

    
         $data = $guru->update([
           'email' => $request->email,
           'username' => $request->username,
           'nama_lengkap' => $request->nama_lengkap,
          //  'level' => 'guru',
           'ttl' => $request->ttl,
           'id_kelas' => $request->id_kelas,
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

    public function updateOrtu(Request $request, $id)
    {
        $user = User::find($id);

        if(!$user) {
           return response()->json([
             'message' => 'Data cannot find',
             'status' => 400,
           ]);
         }

         $request->validate([
            'email' => 'required',
            'username' => 'required',
            'nama_lengkap' => 'required',
            // 'password' => 'required',
            // 'level' => 'required',
            'ttl' => 'required',
            'id_murid' => 'required',
            // 'id_kelas',
        ]);


           $user->email = $request->email;
           $user->username = $request->username;
           $user->nama_lengkap = $request->nama_lengkap;
          //  'password' => Hash::make($request->password),
           $user->ttl = $request->ttl;
           $user->id_murid = $request->id_murid;
           $user->save();
          //  'id_kelas' => $request->id_kelas,
          //  'updated_at' => time(),

        //  $save = $data->save();
        return response()->json([
             'message' => 'Data successfully updated',
            //  'data' => $data,
             'status' => 200,
           ]);

        //  if (!$data) {
        //    return response()->json([
        //      'message' => 'Data cannot updated',
        //      'status' => 400,
        //    ]);
        //  } else {
        //    return response()->json([
        //      'message' => 'Data successfully updated',
        //      'data' => $data,
        //      'status' => 200,
        //    ]);
        //  }
        
    }

    public function destroyUser($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
          'message' => 'delete successfully',
          'status' => 200
        ]);
    }

    public function getUser($id)
    {
        $user = User::find($id);

        if(!$user) {
          return response()->json([
          'message' => 'Failed or Empty data',
          'status' => 400,
        ]);
        }
        return response()->json([
        'message' => 'Success',
        'status' => 200,
        'data' => $user
      ]);
    }

//========================================================================================================================//

public function daftarKelas()
    {
      $kelas = Kelas::all();

      if (!$kelas) {
        return response()->json([
          'message' => 'Failed or Empty data',
          'status' => 400,
        ]);
      }

      return response()->json([
        'message' => 'Success',
        'status' => 200,
        'data' => $kelas
      ]);
    }

    public function tambahKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas',
        ]);


        $kelas = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            // 'created_at' => time(),

        ]);

        if ($kelas) {
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

    public function updateKelas(Request $request, $id)
    {
        $kelas = Kelas::find($id);

        if(!$kelas) {
           return response()->json([
             'message' => 'Data cannot find',
             'status' => 400,
           ]);
         }

         $request->validate([
            'nama_kelas' => 'required|unique:kelas',
        ]);

         

         $data = $kelas->update([
           'nama_kelas' => $request->nama_kelas,
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

    public function destroyKelas($id)
    {
        $kelas = Kelas::find($id);
        $kelas->delete();

        return response()->json([
          'message' => 'delete successfully',
          'status' => 200
        ]);
    }

//========================================================================================================================//

public function daftarMurid()
    {
      $murid = Murid::all();

      if (!$murid) {
        return response()->json([
          'message' => 'Failed or Empty data',
          'status' => 400,
        ]);
      }

      return response()->json([
        'message' => 'Success',
        'status' => 200,
        'data' => $murid
      ]);
    }

    public function tambahMurid(Request $request)
    {
        
        
        $request->validate([
          'nama_lengkap' => 'required',
          'ttl' => 'required',
          'jenis_kelamin' => 'required',
          'id_kelas',
        ]);


        $murid = Murid::create([
          'nama_lengkap' => $request->nama_lengkap,
          'ttl' => $request->ttl,
          'jenis_kelamin' => $request->jenis_kelamin,
          'id_kelas' => $request->id_kelas,
          // 'created_at' => time(),
        ]);

        if ($murid) {
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

    public function updateMurid(Request $request, $id)
    {
        $murid = Murid::find($id);

        if(!$murid) {
           return response()->json([
             'message' => 'Data cannot find',
             'status' => 400,
           ]);
         }

         $request->validate([
            'nama_lengkap' => 'required',
            'ttl' => 'required',
            'jenis_kelamin' => 'required',
            'id_kelas' => 'required',
        ]);

         

         $data = $murid->update([
           'nama_lengkap' => $request->nama_lengkap,
           'ttl' => $request->ttl,
           'jenis_kelamin' => $request->jenis_kelamin,
           'id_kelas' => $request->id_kelas,
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

    public function destroyMurid($id)
    {
        $murid = Murid::find($id);
        $murid->delete();

        return response()->json([
          'message' => 'delete successfully',
          'status' => 200
        ]);
    }

    public function dataMurid($id)
    {
      $murid = Murid::find($id);
      
      if(!$murid){
        return response()->json([
             'message' => 'Data cannot updated',
             'status' => 400,
           ]);
      }

      return response()->json([
        'message' => 'Data successfully updated',
        'data' => $murid,
        'status' => 200,
      ]);
    }

    public function dataKelas($id)
    {
      $kelas = Kelas::find($id);

      if(!$kelas){
        return response()->json([
             'message' => 'Data cannot find',
             'status' => 400,
           ]);
      }

      return response()->json([
        'message' => 'Data successfully find',
        'data' => $kelas,
        'status' => 200,
      ]);
    }

    public function guruKelas($id){
      $isExixts = User::where('id_kelas', $id)->get();
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

    public function muridKelas($id){
      $isExixts = Murid::where('id_kelas', $id)->get();
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

  public function filterlaporan($from, $to) {
    $data = View_hafalan::whereBetween('created_at', [$from,$to])->get();
    if(empty($data)){
      return response()->json([
        'message' => 'Data cannot updated',
        'status' => 400,
      ]);
    }

    return response()->json(['message' => 'Data successfully updated',
      'data' => $data,
      'status' => 200,
    ]);

    // return Excel::download(new HafalanExport($tanggal), 'Hafalan Baru.xlsx');
  }

  public function filterlaporanhafalanlama($from, $to) {
    $data = View_hafalan_lama::whereBetween('created_at', [$from,$to])->get();
    if(empty($data)){
      return response()->json([
        'message' => 'Data cannot updated',
        'status' => 400,
      ]);
    }

    return response()->json(['message' => 'Data successfully updated',
      'data' => $data,
      'status' => 200,
    ]);
    // return Excel::download(new Hafalan_lama_Export($tanggal), 'Hafalan Lama.xlsx');
  }

  public function filterlaporantilawah($from, $to) {
    $data = View_tilawah::whereBetween('created_at', [$from,$to])->get();
    if(empty($data)){
      return response()->json([
        'message' => 'Data cannot updated',
        'status' => 400,
      ]);
    }

    return response()->json(['message' => 'Data successfully updated',
      'data' => $data,
      'status' => 200,
    ]);
    // return Excel::download(new Tilawah_Export($tanggal), 'Tilawah.xlsx');
  }

  public function filterlaporanhafalanrumah($from, $to) {
    $data = View_hafalan_rumah::whereBetween('created_at', [$from,$to])->get();
    if(empty($data)){
      return response()->json([
        'message' => 'Data cannot updated',
        'status' => 400,
      ]);
    }

    return response()->json(['message' => 'Data successfully updated',
      'data' => $data,
      'status' => 200,
    ]);
    // return Excel::download(new Hafalan_Rumah_Export($tanggal), 'Hafalan Baru Rumah.xlsx');
  }

  public function filterlaporanhafalanlamarumah($from, $to) {
    $data = View_hafalan_lama_rumah::whereBetween('created_at', [$from,$to])->get();
    if(empty($data)){
      return response()->json([
        'message' => 'Data cannot updated',
        'status' => 400,
      ]);
    }

    return response()->json(['message' => 'Data successfully updated',
      'data' => $data,
      'status' => 200,
    ]);
    // return Excel::download(new Hafalan_Lama_Rumah_Export($tanggal), 'Hafalan Lama Rumah.xlsx');
  }

  public function filterlaporantilawahmarumah($from, $to) {
    $data = View_tilawah_rumah::whereBetween('created_at', [$from,$to])->get();
    if(empty($data)){
      return response()->json([
        'message' => 'Data cannot updated',
        'status' => 400,
      ]);
    }

    return response()->json(['message' => 'Data successfully updated',
      'data' => $data,
      'status' => 200,
    ]);
    // return Excel::download(new Tilawah_Rumah_Export($tanggal), 'Tilawah Rumah.xlsx');
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
