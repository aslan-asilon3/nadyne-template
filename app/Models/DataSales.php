<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DataTables;

class DataSales extends Model
{
    protected $table = 'data_sales';
    protected $guarded = [];

    public static function datatables($data_sales)
    {
        $datatables = Datatables::of($data_sales)->make(true);

        return $datatables;
    }
}
