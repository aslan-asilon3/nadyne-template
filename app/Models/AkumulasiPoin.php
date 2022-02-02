<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;
use DataTables;

class AkumulasiPoin extends Model
{
    protected $table = 'akumulasi_poin';
    protected $guarded = [];

    public static function datatables($akumulasi_poin)
    {
        $datatables = Datatables::of($akumulasi_poin)
            ->editColumn('created_at', function(AkumulasiPoin $akumulasi_poin) {
                if (!empty($akumulasi_poin->created_at)) {
                    $result = date("d-m-Y H:i:s", strtotime($akumulasi_poin->created_at));
                } else {
                    $result = NULL;
                }

                return $result;
            })
            ->make(true);

        return $datatables;
    }
}
