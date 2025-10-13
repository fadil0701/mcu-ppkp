<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Pages\Dashboard;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandLogo(fn() => view('filament.logo'))
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
                \App\Filament\Pages\AdminNotifications::class,
                \App\Filament\Pages\RescheduleCenter::class,
                \App\Filament\Pages\EmailTemplates::class,
                \App\Filament\Pages\WhatsAppTemplates::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                \App\Filament\Widgets\AdminNotificationsWidget::class,
                \App\Filament\Widgets\DailyQueueWidget::class,
                \App\Filament\Widgets\TodayQueueTable::class,
                \App\Filament\Widgets\DailyQueueChart::class,
                \App\Filament\Widgets\ConfirmRescheduleStatsWidget::class,
                \App\Filament\Widgets\ConfirmedAttendanceTable::class,
            ])
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
            ])
            ->authGuard('web')
            ->defaultAvatarProvider(\Filament\AvatarProviders\UiAvatarsProvider::class)
            ->renderHook(
                'panels::body.end',
                fn (): string => '<script src="' . asset('js/ckeditor5-collaborative.js?v=' . time() . '&t=' . uniqid() . '&u=' . rand(1000, 9999)) . '"></script>'
            )
            ->renderHook(
                'panels::head.end',
                fn (): string => '<link rel="stylesheet" href="' . asset('css/filament-custom.css?v=' . time()) . '">'
            );
    }
}