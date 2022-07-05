<?php

namespace App\Exports;

use App\Models\UnicharmMemberRaw;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUnicharmMemberRaw implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UnicharmMemberRaw::all();
    }

    public function headings(): array {
        return [
            "ID","ID Member","No HP","Status Cek Data","Created At","Updated At"
        ];
    }

}
