<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UnicharmMember;
use App\Models\DataSales;
use App\Models\AkumulasiPoin;
class CekDataSalesMembership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:data_sales_membership';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data_sales = DataSales::whereNull('status_cek_is_member')
                ->where('batch','=','2021-08')
                ->take(10000)
                ->get();

        foreach ($data_sales as $ds) {
            $member = UnicharmMember::where('no_hp', trim($ds->no_hp))->first();
            $data_sales = DataSales::find($ds->id);

            if ($member) {
                $data_sales->status_member = '1';

                echo '1 : '.$ds->id. "\n";
                $data_sales->id_member = $member->id_member;
            } else {
                $data_sales->status_member = '0';

                echo '0 : '.$ds->id. "\n";

            }

            $data_sales->status_cek_is_member = '1';
            $data_sales->save();

            ########################### Perhitungan akumulasi poin
            $akumulasi_poin = AkumulasiPoin::where('no_hp', trim($ds->no_hp))
                ->where('batch', trim($ds->batch))
                ->first();

            if (!$akumulasi_poin) {
                AkumulasiPoin::create([
                    'id_member'     => $ds->id_member,
                    'batch'         => $ds->batch,
                    'no_hp'         => $ds->no_hp,
                    'poin'          => $ds->poin,
                ]);
            } else {
                $data_akumulasi_poin = AkumulasiPoin::find($akumulasi_poin->id);
                $data_akumulasi_poin->poin = $akumulasi_poin->poin + $ds->poin;
                $data_akumulasi_poin->save();
            }

        }
    }
}
