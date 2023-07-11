<?php

namespace App\Exports;

use App\Models\Hafalan_Detail;
use App\Models\View_hafalan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HafalanExport implements FromCollection, WithHeadings
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
        return View_hafalan::where('created_at', $this->tanggal)->get();
    }

    public function headings(): array
    {
        return ["surah", "juz", "ayat", "status", "nama kelas", "nama murid", "Dibuat", "Disunting", "Dihapus"];
    }
}
