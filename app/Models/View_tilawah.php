<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_tilawah extends Model
{
    use HasFactory;

    protected $fillable =[
        'surah','juz','ayat','status','nama_kelas','created_at',
        'updated_at',
    ];

    protected $table = 'view_tilawah';

    protected $casts = [
      'created_at' => 'date:Y-m-d',
      'updated_at' => 'date:Y-m-d',
    ];
}
