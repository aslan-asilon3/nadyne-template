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

    protected $fillable = [
        'id_member',
        'no_hp',
        'batch',
        'poin',
        'status_cek_membership',
    ];

    public static function datatables($akumulasi_poin)
    {
        $datatables = Datatables::of($akumulasi_poin)
            ->editColumn('created_at', function(AkumulasiPoin $akumulasi_poin) {
                // if (!empty($akumulasi_poin->created_at)) {
                //     $result = date("d-m-Y H:i:s", strtotime($akumulasi_poin->created_at));
                // } else {
                //     $result = NULL;
                // }

                return date("d-m-Y H:i:s", strtotime($akumulasi_poin->created_at));
            })
            ->editColumn('status_cek_membership', function($data){
                return $data->status_membership == "1" ? "<span class='badge badge-primary'>Active</span>" : "<span class='badge badge-danger'>Inactive</span>";
            })
            ->rawColumns(['status_cek_membership'])
            ->make(true);

        return $datatables;
    }
}
