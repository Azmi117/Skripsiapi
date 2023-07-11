<?php

namespace App\Exports;

use App\Models\View_tilawah_rumah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Tilawah_Rumah_Export implements FromCollection, WithHeadings
{
    protected $tanggal;

    function __construct($tanggal) {
    $this->tanggal = $tanggal;
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return View_tilawah_rumah::where('created_at', $this->tanggal)->get();
    }

    public function headings(): array
    {
        return ["surah", "juz", "ayat", "status", "nama kelas", "nama murid", "Dibuat", "Disunting", "Dihapus"];
    }
}
