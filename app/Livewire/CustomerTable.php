<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\User;

class CustomerTable extends Component
{
    use WithPagination;

    public $search = '';

    // Form Properties for Add User
    public $name = '';
    public $email = '';
    public $role = 'customer'; // Default role
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,customer',
            'phone' => 'nullable|required_if:role,customer|string|max:20',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function registerUser()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => \Illuminate\Support\Facades\Hash::make($this->password),
            'role' => $this->role,
            'phone' => $this->phone,
        ]);

        $this->resetForm();

        // Dispatch browser event to close modal and show toast
        $this->dispatch('user-registered');
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'role', 'phone', 'password', 'password_confirmation']);
        $this->resetValidation();
    }

    #[On('searchUpdated')]
    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function render()
    {
        $query = User::with('bookings')->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->paginate(10);

        return view('livewire.customer-table', [
            'users' => $users
        ]);
    }
}
