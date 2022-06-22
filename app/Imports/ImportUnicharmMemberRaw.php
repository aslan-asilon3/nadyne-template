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
 
        $UpdateMember->save();


        // dd($cekUpdate);



        // ========logic 3
        $cekNohp = UnicharmMember::where('no_hp', '=', $this->cek($row[2]))->first();
        // dd($cekNohp);

        if($cekNohp){
            // $data = UnicharmMember::where('id', '=', $cekNohp->id)->first();
            // dd($data);
            
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
        // ========End logic 3

        // // ========logic 2
        // if($cekUpdate){
        //     UnicharmMember::create([
        //     $cekUpdate->id_member= $row[1],
        //     $cekUpdate->save()
        //     ]);

        // }else{
        //     return new UnicharmMember([
        //     $cekUpdate->id_member= $row[1],
        //     $cekUpdate->save()
        //   ]);
        // }
        // // ========End logic 2


        // // ======== ke import logic 1
        // $cekUpdate = UnicharmMember::where("no_hp", $this->cek($row[2]))->first();
        // // apabila sudah ada no-hp nya, 
        // // diupdate id-membernya dengan id-member yang terbaru
        // if($cekUpdate){
        //     $cekUpdate->id_member= $row[1];
        //     $cekUpdate->save();
        // }else{
            
        //     // apabila blm ada no-hp nya, 
        //      // diinsert ke unicharm_member no-hp & id_member-nya
        //     return new UnicharmMember([
        //     // 'id' => $row[0],
        //     'id_member' => $row[1],
        //     'no_hp' => $this->cek($row[2]),
        // ]);
        // }

        // // ========End logic 1

        
        // return new UnicharmMemberRaw([
        //     // 'id' => $row[0],
        //     'id_member' => $row[1],
        //     'no_hp' => $this->cek($row[2]),
        //     'status_cek_data' => $row[3],
        // ]);
    }

    public function startRow(): int
    {
        return 2;
    }

}
