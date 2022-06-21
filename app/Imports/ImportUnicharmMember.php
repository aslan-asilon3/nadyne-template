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


        // if (!$cekUpdate) {
        //     $cekUpdate = new CekUpdateNew;
        //     $cekUpdate->id_member = $row[1] ?? null;
        //     $cekUpdate->no_hp = $row[2] ?? null;
        // }

        // $member = UnicharmMember::where('no_hp')->first();

        // if (!$member) {
        //     UnicharmMember::create([
        //         'id_member' => id_member,
        //         'no_hp' => no_hp,
        //     ]);

        //     // echo 'create : '.$clean_no_hp. "\n";
        // } else {
        //     $member->id_member = id_member;
        //     $member->no_hp = no_hp;
        //     $member->save();
        //     // echo 'update : '.$m->id_member. "\n";
        // }

        // $member_raw = UnicharmMemberRaw::find($m->id);
        // $member_raw->status_cek_data = '1';
        // $member_raw->save();


    }

    public function getRowCount(){
        return $this->rowCount;
    }

    public function startRow(): int
    {
        return 2;
    }

}
