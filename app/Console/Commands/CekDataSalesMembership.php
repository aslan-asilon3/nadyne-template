<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UnicharmMember;
use App\Models\DataSales;
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
        $data_sales = DataSales::whereNull('status_cek_is_member')->take(10000)->get();

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
        }
    }
}
