<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DataTables;

class UnicharmMemberRaw extends Model
{
    protected $table = 'unicharm_member_raw';
    protected $guarded = [];

    public static function datatables($data_member_raw)
    {
        $datatables = Datatables::of($data_member_raw)->make(true);

        return $datatables;
    }
}
