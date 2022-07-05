<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
// use DB;
use DataTables;
use App\Models\UnicharmMember;
use App\Models\DataSales;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Imports\ImportUnicharmMember;
use App\Exports\ExportUnicharmMember;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Helpers\CleanNoHP;

class DataMemberController extends Controller
{
    use CleanNoHP;
    function index()
    {
        // $list_batch = UnicharmMember::getBatch();
        $list_batch = UnicharmMember::all();
        $user = Auth::user();
        return view('data_member_index', compact('user', 'list_batch'));
    }



    public function ajax(Request $request)
    {
        $data_member = UnicharmMember::select('id', 'id_member', 'no_hp', 'created_at');
        //var_dump(json_encode($request->id_member));exit();
        if (!empty($request->id_member)) {
            //dd($request->id_member);
            $data_member->where('id_member', $request->id_member);
        }

        if (!empty($request->no_hp)) {
            $data_member->where('no_hp', $request->no_hp);
        }

        $data_member->orderBy('id', 'ASC');

        $datatables = UnicharmMember::datatables($data_member);

        return $datatables;
    }


    public function importexcel(Request $request)
    {
  
        $request->validate([
                'file' => 'required|max:10000|mimes:xlsx,xls',
            ]);
            
        $path = $request->file('file');


       Excel::import(new ImportUnicharmMember, $path);       

        return back()->with('success', 'Excel Data Imported successfully.');
    }

    public function export() 
    {
        return Excel::download(new ExportUnicharmMember, 'data-member ' .now(). '.xlsx');
    }

    // public function actionDownloadExcel($file_name)
    // {
    //     return response()->download(public_path('export/'.$file_name.'.xlsx'));
    // }

        // public function exportExcel(Request $request)
    // {
    //     $data_member = UnicharmMember::select('id', 'id_member', 'no_hp', 'created_at');

    //     if (!empty($request->id_member)) {
    //         $data_member->where('id_member', $request->id_member);
    //     }

    //     if (!empty($request->no_hp)) {
    //         $data_member->where('no_hp', $request->no_hp);
    //     }

    //     $data_member->orderBy('id', 'ASC');
    //     $content = $data_member->get();

    //     $filename = 'data-member-'.date('Y-m-d-H-i');

    //     (new FastExcel($content))->export(public_path('export/'.$filename.'.xlsx'), function ($value) {

    //         return [
    //             'ID'            => $value->id,
    //             'ID MEMBER'     => $value->id_member,
    //             'NO HP'         => $value->no_hp,
    //             'CREATED AT'    => date("d-m-Y H:i:s", strtotime($value->created_at)),
    //         ];
    //     });

    //     return $filename;
    // }

}
