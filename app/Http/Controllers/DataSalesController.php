<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSales;
use Auth;
use DB;
use DataTables;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\DataSales;
class DataSalesController extends Controller
{
    public function index()
    {
        $list_batch = DataSales::getBatch();
        $user = Auth::user();
        return view('data_sales_index', compact('user', 'list_batch'));
    }

    public function ajax(Request $request)
    {
        $data_sales = DataSales::select('id', 'id_member', 'batch', 'poin', 'no_hp', 'tanggal', 'source', 'recipient', 'created_at');
        $data_sales->orderBy('id', 'ASC');
        $datatables = DataSales::datatables($data_sales);

        return $datatables;
    }

    public function exportExcel(Request $request)
    {

    }

    public function actionDownloadExcel($file_name)
    {
        return response()->download(public_path('export/'.$file_name.'.xlsx'));
    }
}
