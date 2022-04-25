<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DataSales;

class CleanNoHP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:no_hp';

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
        //whereNull('status_cek_is_member')
        $data_sales = DataSales::whereNull('status_cek_poin')
                //'2021-07','2021-08','2021-09'
                ->whereIn('batch', ['2022-14'])
                ->take(10000)
                ->get();
                //->toSql();

        //var_dump($data_sales);exit();

        foreach ($data_sales as $ds) {
            $data_sales = DataSales::find($ds->id);

            $char_rep = array("/", ":", "-", ",", "_", "?", "!", "#", "$", "%");
            $data_sales->no_hp = str_replace($char_rep, "", $data_sales->no_hp);

            if (substr(trim($ds->no_hp), 0, 2) == '62') {
                echo '1 : '.substr($data_sales->no_hp, 2). "\n";
                $data_sales->no_hp = substr($data_sales->no_hp, 2);
            } else if (substr(trim($ds->no_hp), 0, 4) == '6262'){
                echo '2 : '.substr($data_sales->no_hp, 4). "\n";
                $data_sales->no_hp = substr($data_sales->no_hp, 4);
            } else {
                if (substr(trim($ds->no_hp), 0, 1) == '0') {
                    echo '3 : '.substr($data_sales->no_hp, 1). "\n";
                    $data_sales->no_hp = substr($data_sales->no_hp, 1);
                }
            }

            $data_sales->status_cek_poin = '1';
            $data_sales->save();
        }
    }
}
