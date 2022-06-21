<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DataTables;
class UnicharmMemberRaw extends Model
{
    use HasFactory;

    protected $table = 'unicharm_member_raw';
    protected $guarded = [];

    public static function datatables($data_member_raw)
    {
        $datatables = Datatables::of($data_member_raw)
            ->editColumn('created_at', function(UnicharmMemberRaw $unicharm_member_raw) {
                if (!empty($unicharm_member_raw->created_at)) {
                    $result = date("d-m-Y H:i:s", strtotime($unicharm_member_raw->created_at));
                } else {
                    $result = NULL;
                }

                return $result;
            })
            // ->orderColumns(['id_member', 'no_hp'], '-:column $1')
            ->make(true);

        return $datatables;
    }

    // public static function getBatch()
    // {
    //     return UnicharmMemberRaw::select('id_member')->groupBy('id_member')->orderBy('id_member', 'asc')->get();
    // }


}
