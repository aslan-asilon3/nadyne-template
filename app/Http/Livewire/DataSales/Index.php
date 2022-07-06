<?php

namespace App\Http\Livewire\DataSales;

use Livewire\Component;
use App\Imports\ImportUnicharmMemberRaw;
use App\Exports\ExportUnicharmMemberRaw;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Helpers\CleanNoHP;
use Carbon\Carbon;

class Index extends Component
{
    use CleanNoHP;

    public $datasales;

    public function render()
    {
        $datasales = 'datasales';
        
        $this->datasales = UnicharmMember::select('id_member','no_hp')->get();
        return view('livewire.unicharm-member.index');


    }  
}
