<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DataTables;

class UnicharmMember extends Model
{
    protected $table = 'unicharm_member';
    protected $guarded = [];

    public static function datatables($data_member)
    {
        $datatables = Datatables::of($data_member)->make(true);

        return $datatables;
    }
}
