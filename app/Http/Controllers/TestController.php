<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnicharmMember;
use App\Models\UnicharmMemberRaw;

class TestController extends Controller
{
    function cekMemberRaw()
    {
        $member_raw = UnicharmMemberRaw::whereNull('status_cek_data')->take(100000)->get();

        foreach ($member_raw as $m) {
            $member = UnicharmMember::where('no_hp', $m->no_hp)->first();

            if (!$member) {
                UnicharmMember::create([
                    'id_member' => $m->id_member,
                    'no_hp' => $m->no_hp,
                ]);

                dump('create : '.$m->id_member);
            } else {
                $member->id_member = $m->id_member;
                $member->save();
                dump('update : '.$m->id_member);
            }

            $member_raw = UnicharmMemberRaw::find($m->id);
            $member_raw->status_cek_data = '1';
            $member_raw->save();
        }
    }
}
