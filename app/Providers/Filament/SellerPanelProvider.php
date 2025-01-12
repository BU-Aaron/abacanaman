<?php

namespace App\Providers\Filament;

use App\Filament\Seller\Pages\Auth\Registration;
use App\Filament\Seller\Pages\Auth\SellerApprovedVerification;
use App\Filament\Seller\Resources\Shop\ConversationResource\Pages\ViewConversation;
use App\Http\Middleware\AuthenticateSeller;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SellerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('seller')
            ->path('seller')
            ->brandLogo(fn() => view('filament.app.logo.seller'))
            ->login()
            ->profile()
            ->registration(Registration::class)
            ->passwordReset()
            ->emailVerification(SellerApprovedVerification::class)
            ->emailVerificationRoutePrefix('pending-verification')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverClusters(in: app_path('Filament/Seller/Clusters'), for: 'App\\Filament\\Seller\\Clusters')
            ->discoverResources(in: app_path('Filament/Seller/Resources'), for: 'App\\Filament\\Seller\\Resources')
            ->discoverPages(in: app_path('Filament/Seller/Pages'), for: 'App\\Filament\\Seller\\Pages')
            ->discoverWidgets(in: app_path('Filament/Seller/Widgets'), for: 'App\\Filament\\Seller\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                AuthenticateSeller::class,
                'role:seller',
            ])
            ->authGuard('seller');
    }
}
