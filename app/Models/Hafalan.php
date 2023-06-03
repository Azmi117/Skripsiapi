<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    use HasFactory;

    protected $fillable =[
        'surah','juz','ayat','id_kelas','created_at',
        'updated_at', 'id_input',
    ];

    protected $table = 'hafalan';

    protected $casts = [
      'created_at' => 'date:Y-m-d',
      'updated_at' => 'date:Y-m-d',
    ];
}
