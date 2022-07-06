<?php

namespace App\Imports;

use App\Models\UnicharmMemberRaw;
use App\Models\UnicharmMember;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Helpers\CleanNoHP;

class ImportUnicharmMemberRaw implements ToModel, WithStartRow
{

    use CleanNoHP;

    public function model(array $row)
    {
        $UpdateMember = new UnicharmMemberRaw;
 
        $UpdateMember->id_member = $row[1];
        $UpdateMember->no_hp = $this->cek($row[2]);
        $UpdateMember->status_cek_data = $row[3];
 
        $UpdateMember->save();


        $cekNohp = UnicharmMember::where('no_hp', '=', $this->cek($row[2]))->first();
        // dd($cekNohp);

        if($cekNohp){
            
            $cekNohp->update([
                'id_member' => $this->cek($row[1])
            ]);

        }
        else{
            UnicharmMember::create([
            'id_member' => $row[1],
            'no_hp'     => $this->cek($row[2])
        ]);
        }
 
    }

    public function startRow(): int
    {
        return 2;
    }

}
