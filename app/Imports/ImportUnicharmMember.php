<?php

namespace App\Imports;

use App\Models\UnicharmMemberRaw;
use App\Models\UnicharmMember;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Helpers\CleanNoHP;

class ImportUnicharmMember implements ToModel, WithStartRow
{
    public $rowCount = 0;
    use CleanNoHP;

    public function model(array $row)
    {
        return new UnicharmMember([
            // 'id' => $row[0],
            'id_member' => $row[1],
            'no_hp' => $this->cek($row[2]),
        ]);




    }

    public function getRowCount(){
        return $this->rowCount;
    }

    public function startRow(): int
    {
        return 2;
    }

}
