<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminForm extends Component
{
    public $name;
    public $email;
    public $password;
    public $is_admin;
    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
        'password' => 'required|string|min:6',
        'is_admin' => 'nullable|boolean'
    ];

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_admin' => $this->is_admin ?? 0,
        ]);

        session()->flash('message', 'Saved.');
        return to_route('admins');
    }

    public function render(): View
    {
        return view('livewire.admin.admin-form');
    }
}
