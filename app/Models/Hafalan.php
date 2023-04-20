<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    use HasFactory;

    protected $fillable =[
        'surat','juz','ayat','status','id_kelas','id_murid','id_penyetor'
    ];
}
