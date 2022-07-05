<?php

namespace App\Http\Livewire\UnicharmMember;

use Livewire\Component;
use App\Models\UnicharmMember;

class Index extends Component
{
    public $datamembers;

    public function render()
    {
        $datamembers = 'datamembers';
        
        $this->datamembers = UnicharmMember::select('id_member','no_hp')->get();
        return view('livewire.unicharm-member.index');


    }  
}
