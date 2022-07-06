<?php

namespace App\Http\Livewire\UnicharmMemberraw;

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

    public $datamembers;

    public function render()
    {
        $datamembers = 'datamembers';
        
        $this->datamembers = UnicharmMember::select('id_member','no_hp')->get();
        return view('livewire.unicharm-member.index');


    }  


}
