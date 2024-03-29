<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable =[
        'nama_kelas','created_at','updated_at','status','id_kelas','id_murid','id_penyetor','created_at','updated_at',
    ];

    protected $table = 'kelas';

    protected $casts = [
      'created_at' => 'date:Y-m-d',
      'updated_at' => 'date:Y-m-d',
    ];
}
