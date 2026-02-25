<?php

namespace App\Livewire;

use Livewire\Component;

class StokFilter extends Component
{
    public $activeFilter = 'all';
    public $emitToDataComponent = 'filterUpdated';

    public function setFilter($jenis)
    {
        $this->activeFilter = $jenis;
        $this->dispatch($this->emitToDataComponent, filter: $this->activeFilter);
    }

    public function render()
    {
        return view('livewire.stok-filter');
    }
}
