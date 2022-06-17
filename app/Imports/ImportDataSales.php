<?php

namespace App\Imports;

use App\Models\DataSales;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportDataSales implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DataSales([
            //
            'id_member' => $row[0],
            'batch' => $row[1],
            'order_id' => $row[2],
            'poin' => $row[3],
            'no_hp' => $row[4],
            'tanggal' => $row[5],
            'source' => $row[6],
            'recipient' => $row[7],
            // 'created_at' => $row[8],
            // 'created_at' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row[8])->format('F Y'),

        ]);
    }
}
