<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingStatusTracker extends Component
{
    public $lastUpdated;

    public function render()
    {
        $activeBookings = Booking::with('services')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved', 'on_progress'])
            ->orderBy('booking_date', 'asc')
            ->get(); // tetap Collection, JANGAN pakai ->toArray()

        $this->lastUpdated = now()->format('H:i:s');

        return view('livewire.booking-status-tracker', [
            'activeBookings' => $activeBookings,
        ]);
    }
}