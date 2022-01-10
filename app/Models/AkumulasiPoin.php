<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DataTables;

class AkumulasiPoin extends Model
{
    protected $table = 'akumulasi_poin';
    protected $guarded = [];

    public static function datatables($akumulasi_poin)
    {
        $datatables = Datatables::of($akumulasi_poin)->make(true);

        return $datatables;
    }
}
