<?php

namespace App\Imports;

use App\Models\DataSales;
use App\Models\UnicharmMember;
use App\Models\AkumulasiPoin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Helpers\CleanNoHP;

class ImportDataSales implements ToModel, WithStartRow
{
    public $rowCount = 0;
    use CleanNoHP;
    
    public function model(array $row)
    {


        // cek no hp data member
        $cekNohp = UnicharmMember::where('no_hp', '=', $this->cek($row[5]))->first();
    

 
        
        // insert data sales
        $UpdateSale = new DataSales;
        $UpdateSale->id_member = $row[1];
        $UpdateSale->batch = $row[2];
        $UpdateSale->order_id = $row[3];
        $UpdateSale->poin = $row[4];
        $UpdateSale->no_hp = $this->cek($row[5]);
        $UpdateSale->tanggal = $row[6] ?? date('Y-m-d');
        $UpdateSale->source = $row[7];
        $UpdateSale->recipient = $row[8];
        $UpdateSale->status_member = $cekNohp == null ? "0" : "1"; // jika tdk ada nomor hp maka insert status member 0 klo ada maka insert 1
        $UpdateSale->status_cek_is_member = $row[10];
        $UpdateSale->status_cek_poin = $row[11];
 
        $UpdateSale->save();

        // Jumlahkan total poin dari batch yang sama
        $SumTotal = DataSales::where('no_hp', '=', $this->cek($row[5]))->where('batch', $row[2])->count();

        // jika nmr hp nya lebih lebih dari 1 maka jumlahkan poin
        if($SumTotal > 1){
            $Sum = DataSales::where('no_hp', '=', $this->cek($row[5]))->where('batch', $row[2])->sum('poin');
            $SumToAkum =  AkumulasiPoin::create([
                'id_member'=> $row[1],
                'no_hp'=> $this->cek($row[5]),
                'batch'=> $row[2],
                'poin'=>$Sum,
                'akumulasi_poin'=> $row[5],
            ]);
        }


        
        $data_sales = DataSales::whereNull('status_cek_is_member')
        //
        ->where('batch', '2022-21')
        ->take(10000)
        ->get();

       

    }

    public function getRowCount(){
        return $this->rowCount;
    }

    public function startRow(): int
    {
        return 2;
    }


}
