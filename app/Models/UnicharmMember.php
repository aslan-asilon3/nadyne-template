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
        $datatables = Datatables::of($data_member)
            ->editColumn('created_at', function(UnicharmMember $unicharm_member) {
                if ($unicharm_member->created_at) {
                    $result = date("d-m-Y H:i:s", strtotime($unicharm_member->created_at));
                } else {
                    $result = NULL;
                }

                return $result;
            })
            ->make(true);

        return $datatables;
    }
}
