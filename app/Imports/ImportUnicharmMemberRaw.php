<?php

namespace App\Imports;

use App\Models\UnicharmMemberRaw;
use App\Models\UnicharmMember;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Helpers\CleanNoHP;

// use Maatwebsite\Excel\Concerns\ToCollection;

class ImportUnicharmMemberRaw implements ToModel, WithStartRow
{

    use CleanNoHP;


     public function model(array $row)
    {
        // dd($row[0]);
        $UpdateMember = new UnicharmMemberRaw;

        if ($row[1] === null || $row[0] === null ) {
            return null;
        }
 
        $UpdateMember->id_member = $row[0];
        $UpdateMember->no_hp = $this->cek($row[1]);
        // $UpdateMember->no_hp = '0'.$this->cek($row[1]);
        $UpdateMember->status_cek_data = $row[3] == null ? "0" : "1"; // jika tdk status cek data maka insert status cek data 0 klo ada maka insert 1


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


    // public function collection(Collection $rows)
    // {
    //    foreach($rows as $row) {
    //     $em1=trim($row[1]);           

    //     $em = collect([$em1]);
       

    //     if($em->filter()->isNotEmpty()){
    //         // you logic can go here

    //         $dataRaw = UnicharmMemberRaw::create([
    //             'id_member'     => $row[0],
    //             'no_hp'     => $row[1],
    //             'status_cek_data'     => $row[3],
    //         ]);
    //     }

    //     $cekNohp = UnicharmMember::where('no_hp', '=', $this->cek($row[1]))->first();
    //     // dd($cekNohp);

    //     if($cekNohp){
            
    //         $cekNohp->update([
    //             'id_member' => $this->cek($row[0])
    //         ]);

    //     }
    //     else{
    //         UnicharmMember::create([
    //         'id_member' => $row[0],
    //         'no_hp'     => '0'.$this->cek($row[1])
    //     ]);
    //     }

    //   }
    // }





    // public function model(array $row)
    // {
    //     // dd($row[0]);
    //     $UpdateMember = new UnicharmMemberRaw;

 
    //     $UpdateMember->id_member = $row[0];
    //     $UpdateMember->no_hp = $this->cek($row[1]);
    //     // $UpdateMember->no_hp = '0'.$this->cek($row[1]);
    //     $UpdateMember->status_cek_data = $row[3] ?? NULL;

    //     $UpdateMember->save();


    //     $cekNohp = UnicharmMember::where('no_hp', '=', $this->cek($row[1]))->first();
    //     // dd($cekNohp);

    //     if($cekNohp){
            
    //         $cekNohp->update([
    //             'id_member' => $this->cek($row[0])
    //         ]);

    //     }
    //     else{
    //         UnicharmMember::create([
    //         'id_member' => $row[0],
    //         'no_hp'     => '0'.$this->cek($row[1])
    //     ]);
    //     }
 
    // }




    public function startRow(): int
    {
        return 2;
    }

}
