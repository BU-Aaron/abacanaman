<?php

namespace App\Filament\Seller\Pages\Auth;

use Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt;
use Illuminate\Support\Facades\Auth;

class SellerApprovedVerification extends EmailVerificationPrompt
{
    public function logout()
    {
        Auth::logout();
        return redirect('/seller');
    }

    public function getView(): string
    {
        return 'filament.seller.pages.auth.verification-status';
    }
}
