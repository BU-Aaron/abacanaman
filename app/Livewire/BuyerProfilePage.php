<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BuyerProfilePage extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $phone_number;
    public $address;
    public $city;
    public $state;
    public $zip_code;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->address = $user->address;
        $this->city = $user->city;
        $this->state = $user->state;
        $this->zip_code = $user->zip_code;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . ',id',
        'password' => 'nullable|confirmed|min:6',
        'phone_number' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'zip_code' => 'nullable|string|max:255',
    ];

    public function updateProfile()
    {
        $user = Auth::user();
        $user = User::find($user->id);

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'phone_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
        ]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;
        $user->address = $this->address;
        $user->city = $this->city;
        $user->state = $this->state;
        $user->zip_code = $this->zip_code;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('message', 'Profile updated successfully.');

        return redirect()->route('buyer.profile');
    }

    public function render()
    {
        return view('livewire.buyer-profile-page');
    }
}
