<?php

namespace App\Imports;

use App\Models\UnicharMember;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportUnicharmMember implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new UnicharmMember([
            'id_member' => $row[0],
            'no_hp' => $row[1],
        ]);
    }
}
