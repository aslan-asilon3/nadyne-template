<?php

namespace App\Http\Livewire\AkumulasiPoin;

use Livewire\Component;
use App\Imports\ImportUnicharmMemberRaw;
use App\Exports\ExportUnicharmMemberRaw;
use App\Models\AkumulasiPoin;

class Index extends Component
{
    public function render()
    {
        $akumulasipoin = 'akumulasipoin';
        
        $this->akumulasipoin = AkumulasiPoin::select('id_member','no_hp','batch','poin','status_cek_membership')->get();
        return view('livewire.akumulasi-poin.index');
    }
}
