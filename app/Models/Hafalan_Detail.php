<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hafalan_Detail extends Model
{
    use HasFactory;

    protected $fillable =[
        'surah','juz','ayat','status','id_kelas','id_murid','id_penyetor','created_at',
        'updated_at', 'id_input',
    ];

    protected $table = 'hafalan_detail';

    protected $casts = [
      'created_at' => 'date:Y-m-d',
      'updated_at' => 'date:Y-m-d',
    ];
}
