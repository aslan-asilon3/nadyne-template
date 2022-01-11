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
        $datatables = Datatables::of($data_sales)
            ->editColumn('created_at', function(DataSales $data_sales) {

                if ($data_sales->created_at) {
                    $result = date("d-m-Y H:i:s", strtotime($data_sales->created_at));
                } else {
                    $result = NULL;
                }

                return $result;
            })
            ->make(true);

        return $datatables;
    }

    public static function getBatch()
    {
        return DataSales::select('batch')->groupBy('batch')->get();
    }
}
