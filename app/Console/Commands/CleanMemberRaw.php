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
        $member_raw = UnicharmMemberRaw::whereNull('status_cek_data')->take(100000)->get();

        foreach ($member_raw as $m) {
            $member = UnicharmMember::where('no_hp', $m->no_hp)->first();

            if (!$member) {
                UnicharmMember::create([
                    'id_member' => $m->id_member,
                    'no_hp' => $m->no_hp,
                ]);

                echo 'create : '.$m->id_member. "\n";
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
