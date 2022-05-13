<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UnicharmMember;
use App\Models\UnicharmMemberRaw;

class CleanMemberRaw extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:member_raw';

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
        $member_raw = UnicharmMemberRaw::whereNull('status_cek_data')
            ->where('id', '>' , 1611150)
            ->take(50000)
            ->get();

        foreach ($member_raw as $m) {

            $char_rep = array("/", "+", ":", "-", ",", "_", "?", "!", "#", "$", "%");
            $clean_no_hp = str_replace($char_rep, "", $m->no_hp);

            if (substr(trim($clean_no_hp), 0, 2) == '62') {
                echo '1 : '.substr($clean_no_hp, 2). "\n";
                $clean_no_hp = substr($clean_no_hp, 2);
            } else if (substr(trim($clean_no_hp), 0, 4) == '6262'){
                echo '2 : '.substr($clean_no_hp, 4). "\n";
                $clean_no_hp = substr($clean_no_hp, 4);
            } else {
                if (substr(trim($clean_no_hp), 0, 1) == '0') {
                    echo '3 : '.substr($clean_no_hp, 1). "\n";
                    $clean_no_hp = substr($clean_no_hp, 1);
                }
            }

            $member = UnicharmMember::where('no_hp', $clean_no_hp)->first();

            if (!$member) {
                UnicharmMember::create([
                    'id_member' => $m->id_member,
                    'no_hp' => $clean_no_hp,
                ]);

                echo 'create : '.$clean_no_hp. "\n";
            } else {
                $member->id_member = $m->id_member;
                $member->save();
                echo 'update : '.$m->id_member. "\n";
            }

            $member_raw = UnicharmMemberRaw::find($m->id);
            $member_raw->status_cek_data = '1';
            $member_raw->save();
        }
    }
}
