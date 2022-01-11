<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use App\Models\AkumulasiPoin;
use App\Models\DataSales;
use Rap2hpoutre\FastExcel\FastExcel;

class AkumulasiPoinController extends Controller
{
    function index()
    {
        $list_batch = DataSales::getBatch();
        $user = Auth::user();
        return view('akumulasi_poin_index', compact('user', 'list_batch'));
    }

    public function ajax(Request $request)
    {
        $akumulasi_poin = AkumulasiPoin::select('id', 'id_member', 'no_hp', 'batch', 'poin', 'created_at');
        $akumulasi_poin->orderBy('id', 'ASC');

        if (!empty($request->no_hp)) {
            $akumulasi_poin->where('no_hp', $request->no_hp);
        }

        if (!empty($request->batch)) {
            $akumulasi_poin->where('batch', $request->batch);
        }

        $datatables = AkumulasiPoin::datatables($akumulasi_poin);

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
