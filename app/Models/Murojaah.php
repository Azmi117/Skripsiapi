<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murojaah extends Model
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

      protected $table = 'murojaah';
}
