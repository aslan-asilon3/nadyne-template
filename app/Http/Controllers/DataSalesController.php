<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSales;
use Auth;
use DB;
use DataTables;
use Rap2hpoutre\FastExcel\FastExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportDataSales;
use Carbon\Carbon;

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
        DB::enableQueryLog(); // Enable query log
        $data_sales = DataSales::select('id', 'id_member', 'order_id', 'batch', 'poin', 'no_hp', 'tanggal', 'source', 'recipient', 'created_at');

        // \Log::info('is-member : '.$request->is_member);
        // \Log::info(true == ($request->is_member == '0'));

        if ($request->is_member == '1') {
            $data_sales->whereNotNull('id_member');
        } elseif ($request->is_member == '0') {
            $data_sales->whereNull('id_member');
        }

        if (!empty($request->order_id)) {
            $data_sales->where('order_id', $request->order_id);
        }

        if (!empty($request->no_hp)) {
            $data_sales->where('no_hp', $request->no_hp);
        }

        if (!empty($request->batch)) {
            $data_sales->where('batch', $request->batch);
        }

        if (!empty($request->poin)) {
            $data_sales->where('poin', $request->poin);
        }

        if (!empty($request->recipient)) {
            $data_sales->where('recipient', $request->recipient);
        }

        if (!empty($request->source)) {
            $data_sales->where('source', $request->source);
        }

        $data_sales->orderBy('id', 'ASC');
        $datatables = DataSales::datatables($data_sales);

        // \Log::info('SQL Ajax data-sales:');
        // \Log::info(DB::getQueryLog());

        return $datatables;
    }

    public function exportExcel(Request $request)
    {
        $data_sales = DataSales::select('id', 'id_member', 'order_id', 'batch', 'poin', 'no_hp', 'tanggal', 'source', 'recipient', 'created_at');

        if ($request->is_member == '1') {
            $data_sales->whereNotNull('id_member');
        } elseif ($request->is_member == '0') {
            $data_sales->whereNull('id_member');
        }

        if (!empty($request->order_id)) {
            $data_sales->where('order_id', $request->order_id);
        }

        if (!empty($request->no_hp)) {
            $data_sales->where('no_hp', $request->no_hp);
        }

        if (!empty($request->batch)) {
            $data_sales->where('batch', $request->batch);
        }

        if (!empty($request->poin)) {
            $data_sales->where('poin', $request->poin);
        }

        if (!empty($request->recipient)) {
            $data_sales->where('recipient', $request->recipient);
        }

        if (!empty($request->source)) {
            $data_sales->where('source', $request->source);
        }

        $data_sales->orderBy('id', 'ASC');

        $content = $data_sales->get();

        $filename = 'data-sales-'.date('Y-m-d-H-i');

        (new FastExcel($content))->export(public_path('export/'.$filename.'.xlsx'), function ($value) {

            return [
                'ID'            => $value->id,
                'ID MEMBER'     => $value->id_member,
                'ORDER ID'      => $value->order_id,
                'NO HP'         => $value->no_hp,
                'TANGGAL'       => $value->tanggal,
                'BATCH'         => $value->batch,
                'POIN'          => $value->poin,
                'RECIPIENT'     => $value->recipient,
                'SOURCE'        => $value->source,
                'CREATED AT'    => date("d-m-Y H:i:s", strtotime($value->created_at)),
            ];
        });

        return $filename;
    }


    public function importexcel(Request $request)
    {   
        $request->validate([
                'file' => 'required|max:10000|mimes:xlsx,xls',
            ]);
            
        $path = $request->file('file');

        Excel::import(new ImportDataSales, $path); 
        
        
        return back();
    }

    public function actionDownloadExcel($file_name)
    {
        return response()->download(public_path('export/'.$file_name.'.xlsx'));
    }
}
