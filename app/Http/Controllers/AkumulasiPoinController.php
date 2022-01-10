<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use App\Models\AkumulasiPoin;

class AkumulasiPoinController extends Controller
{
    function index()
    {
        $user = Auth::user();
        return view('akumulasi_poin_index', compact('user'));
    }

    public function ajax(Request $request)
    {
        $akumulasi_poin = AkumulasiPoin::select('id', 'id_member', 'no_hp', 'batch', 'poin', 'created_at');
        $akumulasi_poin->orderBy('id', 'ASC');
        $datatables = AkumulasiPoin::datatables($akumulasi_poin);

        return $datatables;
    }
}
