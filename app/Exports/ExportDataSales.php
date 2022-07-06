<?php

namespace App\Exports;

use App\Models\DataSales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDataSales implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DataSales::all();
    }

    public function headings(): array {
        return [
            "ID","ID Member","Batch","order ID","Poin","NO HP","Tanggal","Source","Recipient","Status member","Status Cek Is Member","Status Cek Poin","Created At","Updated At"
        ];
    }
}
