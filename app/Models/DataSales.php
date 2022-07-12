<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DataTables;

class DataSales extends Model
{
    protected $table = 'data_sales';
    protected $guarded = [];


    protected $fillable = [
        'id_member',
        'batch',
        'order_id',
        'poin',
        'no_hp',
        'tanggal',
        'source',
        'recipient',
        'status_member',
        'status_cek_is_member',
        'status_cek_poin',
    ];

    public static function datatables($data_sales)
    {
        $datatables = Datatables::of($data_sales)
            ->editColumn('created_at', function(DataSales $data_sales) {

                if (!empty($data_sales->created_at)) {
                    $result = date("d-m-Y H:i:s", strtotime($data_sales->created_at));
                } else {
                    $result = NULL;
                }

                return $result;
            })
            ->editColumn('status_cek_is_member', function($data){
                return $data->status_cek_data == "1" ? "<span class='badge badge-primary'>Active</span>" : "<span class='badge badge-danger'>Inactive</span>";
            })
            ->rawColumns(['status_cek_is_member'])
            ->make(true);

        return $datatables;
    }

    public static function getBatch()
    {
        return DataSales::select('batch')->groupBy('batch')->orderBy('batch', 'asc')->get();
    }
}
