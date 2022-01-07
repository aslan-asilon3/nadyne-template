<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AkumulasiPoin;
use App\Models\UnicharmMember;
class CekPoinMembership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:poin_member_status';

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
        $data_poin = AkumulasiPoin::whereNull('status_cek_membership')->take(80000)->get();

        foreach ($data_poin as $dp) {
            $member = UnicharmMember::where('no_hp', trim($dp->no_hp))->first();

            $data_poin = AkumulasiPoin::find($dp->id);

            if ($member) {
                echo 'member-found : '.$dp->id. "\n";
                $data_poin->id_member = $member->id_member;
                $data_poin->status_cek_membership = '1';

            } else {
                echo 'member-not-found : '.$dp->id. "\n";
                $data_poin->status_cek_membership = '1';
            }

            $data_poin->save();
        }
        //return 0;
    }
}
