<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'ttl',
        'jenis_kelamin',
        'id_kelas',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $table = 'murid';

    protected $casts = [
      'created_at' => 'date:Y-m-d',
      'updated_at' => 'date:Y-m-d',
    ];
}
