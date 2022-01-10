<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSales;
use Auth;
use DB;
use DataTables;

class DataSalesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('data_sales_index', compact('user'));
    }

    public function ajax(Request $request)
    {
        $data_sales = DataSales::select('id', 'id_member', 'batch', 'poin', 'no_hp', 'tanggal', 'source', 'recipient', 'created_at');
        $data_sales->orderBy('id', 'ASC');
        $datatables = DataSales::datatables($data_sales);

        return $datatables;
    }
}
