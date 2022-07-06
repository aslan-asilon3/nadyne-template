<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Models\UnicharmMemberRaw;
use App\Models\DataSales;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Imports\ImportUnicharmMemberRaw;
use App\Exports\ExportUnicharmMemberRaw;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Helpers\CleanNoHP;
use Carbon\Carbon;

class DataMemberRawController extends Controller
{
    //
    use CleanNoHP;
    function index()
    {
        // $list_batch = UnicharmMemberRaw::getBatch();
        $list_batch = UnicharmMemberRaw::all();
        $user = Auth::user();
        return view('data_member_raw_index', compact('user', 'list_batch'));
    }



    public function ajax(Request $request)
    {
        DB::enableQueryLog(); // Enable query log
        $data_member_raw = UnicharmMemberRaw::select('id', 'id_member','no_hp', 'status_cek_data', 'created_at');

        // \Log::info('is-member : '.$request->is_member);
        // \Log::info(true == ($request->is_member == '0'));

        if ($request->is_member == '1') {
            $data_member_raw->whereNotNull('id_member');
        } elseif ($request->is_member == '0') {
            $data_member_raw->whereNull('id_member');
        }

        if (!empty($request->no_hp)) {
            $data_member_raw->where('no_hp', $request->no_hp);
        }

        if (!empty($request->recipient)) {
            $data_member_raw->where('status_cek_data', $request->status_cek_data);
        }

        $data_member_raw->orderBy('id', 'ASC');
        $datatables = UnicharmMemberRaw::datatables($data_member_raw);

        // \Log::info('SQL Ajax data-sales:');
        // \Log::info(DB::getQueryLog());

        return $datatables;
    }

    public function export() 
    {
        
        return Excel::download(new ExportUnicharmMemberRaw, 'data-member-raw ' .now(). '.xlsx');
    }



    public function import(Request $request) 
    {
        // dd($request->all());
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ]);
        
        $path = $request->file('file');

 
        Excel::import(new ImportUnicharmMemberRaw,$path);
 
            
        return redirect('/data-member-raw')->with('success', 'The file has been excel imported to database ');
    }

    // public function ajax(Request $request)
    // {
    //     $data_member = UnicharmMemberRaw::select('id', 'id_member', 'no_hp', 'status_cek_data','created_at');
    //     //var_dump(json_encode($request->id_member));exit();
    //     if (!empty($request->id_member)) {
    //         //dd($request->id_member);
    //         $data_member_raw->where('id_member', $request->id_member);
    //     }

    //     if (!empty($request->no_hp)) {
    //         $data_member_raw->where('no_hp', $request->no_hp);
    //     }


    //     if (!empty($request->status_cek_data)) {
    //         $data_member_raw->where('status_cek_data', $request->status_cek_data);
    //     }

    //     $data_member_raw->orderBy('id', 'ASC');

    //     $datatables = UnicharmMemberRaw::datatables($data_member_raw);

    //     return $datatables;
    // }




    // public function actionDownloadExcel($file_name)
    // {
    //     return response()->download(public_path('export/'.$file_name.'.xlsx'));
    // }

        // public function exportExcel(Request $request)
    // {
    //     $data_member_raw = UnicharmMemberRaw::select('id', 'id_member', 'no_hp','status_cek_data', 'created_at');

    //     if (!empty($request->id_member)) {
    //         $data_member_raw->where('id_member', $request->id_member);
    //     }

    //     if (!empty($request->no_hp)) {
    //         $data_member_raw->where('no_hp', $request->no_hp);
    //     }

    //     if (!empty($request->status_cek_data)) {
    //         $data_member_raw->where('status_cek_data', $request->status_cek_data);
    //     }

    //     $data_member_raw->orderBy('id', 'ASC');
    //     $content = $data_member_raw->get();

    //     $filename = 'data-member-raw'.date('Y-m-d-H-i');

    //     (new FastExcel($content))->export(public_path('export/'.$filename.'.xlsx'), function ($value) {

    //         return [
    //             'ID'               => $value->id,
    //             'ID MEMBER'        => $value->id_member,
    //             'NO HP'            => $value->no_hp,
    //             'STATUS CEK DATA'  => $value->status_cek_data,
    //             'CREATED AT'    => date("d-m-Y H:i:s", strtotime($value->created_at)),
    //         ];
    //     });

    //     return $filename;
    // }
}
