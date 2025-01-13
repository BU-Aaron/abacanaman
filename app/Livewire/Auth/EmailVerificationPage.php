<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Verify Email')]
class EmailVerificationPage extends Component
{
    public function resend()
    {
        $user = Auth::user();
        $user = User::find($user->id);

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended('/');
        }

        $user->sendEmailVerificationNotification();

        session()->flash('message', 'Verification link sent!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.auth.email-verification-page')->layout('components.layouts.guest');
    }
}
