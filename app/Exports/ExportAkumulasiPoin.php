<?php

namespace App\Exports;

use App\Models\AkumulasiPoin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportAkumulasiPoin implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AkumulasiPoin::all();
    }

    public function headings(): array {
        return [
            "ID","ID Member","No HP","Batch", "Poin", "Status Cek Membership", "Created At","Updated At"
        ];
    }

}
