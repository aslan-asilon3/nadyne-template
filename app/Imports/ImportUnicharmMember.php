<?php

namespace App\Imports;

use App\Models\UnicharmMember;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportUnicharmMember implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new UnicharmMember([
            // 'id' => $row[0],
            'id_member' => $row[1],
            'no_hp' => $row[2],
        ]);
    }


    public function startRow(): int
    {
        return 2;
    }

}
