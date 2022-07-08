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
        // dd($row[0]);
        $UpdateMember = new UnicharmMemberRaw;
 
        $UpdateMember->id_member = $row[0];
        $UpdateMember->no_hp = '0'.$this->cek($row[1]);
        $UpdateMember->status_cek_data = $row[3] ?? NULL;
 
        $UpdateMember->save();


        $cekNohp = UnicharmMember::where('no_hp', '=', $this->cek($row[1]))->first();
        // dd($cekNohp);

        if($cekNohp){
            
            $cekNohp->update([
                'id_member' => $this->cek($row[0])
            ]);

        }
        else{
            UnicharmMember::create([
            'id_member' => $row[0],
            'no_hp'     => '0'.$this->cek($row[1])
        ]);
        }
 
    }

    public function startRow(): int
    {
        return 2;
    }

}
