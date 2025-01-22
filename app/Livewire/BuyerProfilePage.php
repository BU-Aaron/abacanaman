<?php

namespace App\Livewire;

use App\Models\Address;
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

    // Properties for managing multiple addresses
    public $addresses;
    public $newAddress = [
        'address' => '',
        'city' => '',
        'state' => '',
        'zip_code' => '',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->addresses = $user->addresses()->get()->toArray();
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . ',id',
        'password' => 'nullable|confirmed|min:6',
        'phone_number' => 'nullable|string|max:255',
    ];

    // Validation rules for new addresses
    protected $rulesNewAddress = [
        'newAddress.address' => 'required|string|max:255',
        'newAddress.city' => 'required|string|max:100',
        'newAddress.state' => 'required|string|max:100',
        'newAddress.zip_code' => 'required|string|max:20',
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
        ]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('message', 'Profile updated successfully.');

        return redirect()->route('buyer.profile');
    }

    public function addAddress()
    {
        $this->validate([
            'newAddress.address' => 'required|string|max:255',
            'newAddress.city' => 'required|string|max:100',
            'newAddress.state' => 'required|string|max:100',
            'newAddress.zip_code' => 'required|string|max:20',
        ]);

        $user = Auth::user();

        $address = new Address([
            'street' => $this->newAddress['address'],
            'city' => $this->newAddress['city'],
            'state' => $this->newAddress['state'],
            'zip' => $this->newAddress['zip_code'],
        ]);

        $user->addresses()->save($address);

        // Reset the form
        $this->newAddress = [
            'address' => '',
            'city' => '',
            'state' => '',
            'zip_code' => '',
        ];

        // Refresh the addresses list
        $this->addresses = $user->addresses()->get()->toArray();

        session()->flash('message', 'Address added successfully.');
    }

    public function removeAddress($addressId)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($addressId);
        $address->delete();

        // Remove the address from the addresses array
        $this->addresses = array_filter($this->addresses, function ($addr) use ($addressId) {
            return $addr['id'] !== $addressId;
        });

        session()->flash('message', 'Address removed successfully.');
    }

    public function render()
    {
        return view('livewire.buyer-profile-page');
    }
}
