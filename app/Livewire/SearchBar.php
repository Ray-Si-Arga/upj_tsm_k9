<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBar extends Component
{
    public $search = '';
    public $placeholder = 'Cari...';

    // allow passing event name dynamically to reuse component
    public $emitToDataComponent = 'searchUpdated';

    public function updatedSearch()
    {
        $this->dispatch($this->emitToDataComponent, search: $this->search);
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
