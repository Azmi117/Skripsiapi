<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tilawah extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'surah',
        'juz',
        'ayat',
        'id_kelas',
        'created_at',
        'updated_at',
      ];

      protected $table = 'tilawah';

      protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
      ];
    
}
