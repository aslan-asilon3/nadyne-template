<?php

namespace App\Imports;

use App\Models\UnicharmMemberRaw;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportUnicharmMemberRaw implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new UnicharmMemberRaw([
            // 'id' => $row[0],
            'id_member' => $row[1],
            'no_hp' => $row[2],
            'status_cek_data' => $row[3],
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

}
