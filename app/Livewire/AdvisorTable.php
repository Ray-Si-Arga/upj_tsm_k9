<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ServiceAdvisor;

class AdvisorTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = ServiceAdvisor::with(['booking.services']);

        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mekanik', 'like', "%{$search}%")
                    ->orWhereHas('booking', function ($b) use ($search) {
                        $b->where('plate_number', 'like', "%{$search}%")
                            ->orWhere('customer_name', 'like', "%{$search}%")
                            ->orWhere('vehicle_type', 'like', "%{$search}%");
                    });
            });
        }

        $histories = $query->latest()->paginate(10);

        return view('livewire.advisor-table', [
            'histories' => $histories,
        ]);
    }
}