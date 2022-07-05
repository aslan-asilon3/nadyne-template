<?php

namespace App\Exports;

use App\Models\UnicharmMember;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUnicharmMember implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return UnicharmMember::all();
    }

    public function headings(): array {
        return [
            "ID","ID Member","No HP","Created At","Updated At"
        ];
    }
}
