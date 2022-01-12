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

        if (!empty($request->poin)) {
            $akumulasi_poin->where('poin', $request->poin);
        }

        $datatables = AkumulasiPoin::datatables($akumulasi_poin);

        return $datatables;
    }

    public function exportExcel(Request $request)
    {
        $akumulasi_poin = AkumulasiPoin::select('id', 'id_member', 'no_hp', 'batch', 'poin', 'created_at');

        if (!empty($request->no_hp)) {
            $akumulasi_poin->where('no_hp', $request->no_hp);
        }

        if (!empty($request->batch)) {
            $akumulasi_poin->where('batch', $request->batch);
        }

        if (!empty($request->poin)) {
            $akumulasi_poin->where('poin', $request->poin);
        }

        $akumulasi_poin->orderBy('id', 'ASC');

        $content = $akumulasi_poin->get();

        $filename = 'akumulasi-poin-'.date('Y-m-d-H-i');

        (new FastExcel($content))->export(public_path('export/'.$filename.'.xlsx'), function ($value) {

            return [
                'ID'            => $value->id,
                'ID MEMBER'     => $value->id_member,
                'NO HP'         => $value->no_hp,
                'BATCH'         => $value->batch,
                'POIN'          => $value->poin,
                'CREATED AT'    => $value->created_at
            ];
        });

        return $filename;
    }

    public function actionDownloadExcel($file_name)
    {
        return response()->download(public_path('export/'.$file_name.'.xlsx'));
    }
}
