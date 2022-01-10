<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DataTables;
use App\Models\UnicharmMember;

class DataMemberController extends Controller
{
    function index()
    {
        $user = Auth::user();
        return view('data_member_index', compact('user'));
    }

    public function ajax(Request $request)
    {
        $data_member = UnicharmMember::select('id', 'id_member', 'no_hp', 'batch', 'poin', 'created_at');
        $data_member->orderBy('id', 'ASC');
        $datatables = UnicharmMember::datatables($data_member);

        return $datatables;
    }
}
