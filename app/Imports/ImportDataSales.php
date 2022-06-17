<?php

namespace App\Imports;

use App\Models\DataSales;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class ImportDataSales implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new DataSales([
            //
            'id_member' => $row[1],
            'order_id' => $row[2],
            'no_hp' => $row[3],
            'tanggal' => $row[4],
            'batch' => $row[5],
            'poin' => $row[6],
            'recipient' => $row[7],
            'source' => $row[8],
            // 'created_at' => $row[8],
            // 'created_at' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row[8])->format('F Y'),

        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
