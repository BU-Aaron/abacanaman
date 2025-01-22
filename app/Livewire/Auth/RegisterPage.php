<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register')]
class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $phone_number;
    public $street_address;
    public $city;
    public $province;
    public $zip_code;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255|confirmed',
            'phone_number' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => User::ROLE_BUYER,
            'phone_number' => $this->phone_number,
        ]);

        $user->addresses()->create([
            'street' => $this->street_address,
            'city' => $this->city,
            'state' => $this->province,
            'zip' => $this->zip_code,
        ]);

        Auth::login($user);

        // Send verification email
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
