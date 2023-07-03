<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tilawah_rumah extends Model
{
    use HasFactory;

    protected $fillable =[
        'surah','juz','ayat','status','id_murid','created_at',
        'updated_at',
    ];

    protected $table = 'tilawah_rumah';
  
      public function user()
      {
        return $this->belongsTo(User::class);
      }

      protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];
}