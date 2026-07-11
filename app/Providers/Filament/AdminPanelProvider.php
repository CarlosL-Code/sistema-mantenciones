<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset()
            ->profile()
            ->brandName('San Julián CMMS')
            ->brandLogo(asset('images/sanjulian_logo.png'))
            ->brandLogoHeight('3rem')
            ->databaseNotifications()
            ->favicon(asset('favicon.png'))
            ->colors([
                'primary' => \Filament\Support\Colors\Color::Indigo,
                'secondary' => \Filament\Support\Colors\Color::Slate,
                'success' => \Filament\Support\Colors\Color::Emerald,
                'info' => \Filament\Support\Colors\Color::Blue,
                'warning' => \Filament\Support\Colors\Color::Amber,
                'danger' => \Filament\Support\Colors\Color::Rose,
                'gray' => \Filament\Support\Colors\Color::Slate,
            ])
            ->font('Inter')
            ->darkMode(false)
            ->maxContentWidth('full')
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => Blade::render('
                    <link rel="manifest" href="/manifest.json">
                    <meta name="theme-color" content="#4f46e5">
                    <link rel="apple-touch-icon" href="/icon-192x192.png">
                    <style>
                        /* Estilos corporativos premium */
                        .fi-topbar {
                            background: rgba(255, 255, 255, 0.8) !important;
                            backdrop-filter: blur(16px) !important;
                            -webkit-backdrop-filter: blur(16px) !important;
                            border-bottom: 1px solid rgba(0, 0, 0, 0.04) !important;
                            border-top: none !important;
                            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03) !important;
                        }
                        
                        /* Transiciones suaves para barra lateral y contenido */
                        .fi-sidebar, .fi-sidebar-nav, .fi-main, aside.fi-sidebar {
                            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
                        }
                        
                        /* Buscador redondeado y suave */
                        .fi-topbar input[type="search"] {
                            background-color: #f8fafc !important;
                            border: 1px solid #e2e8f0 !important;
                            border-radius: 9999px !important;
                            padding-left: 2.5rem !important;
                            transition: all 0.2s ease !important;
                        }
                        .fi-topbar input[type="search"]:focus {
                            background-color: #ffffff !important;
                            border-color: #4f46e5 !important;
                            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
                        }

                        /* Menú lateral activo */
                        .fi-sidebar-item-active {
                            border-left: 3px solid #4f46e5;
                            background: linear-gradient(90deg, #eef2ff 0%, transparent 100%) !important;
                        }
                    </style>
                    <script>
                        if ("serviceWorker" in navigator) {
                            navigator.serviceWorker.register("/sw.js").then(function() {
                                console.log("Service Worker Registered");
                            });
                        }
                    </script>
                ')
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\PremiumWelcomeWidget::class,
            ])
            ->icons([
                'panels::sidebar.collapse-button' => 'heroicon-m-bars-3-bottom-left',
                'panels::sidebar.expand-button' => 'heroicon-m-bars-3',
                'panels::sidebar.group.collapse-button' => 'heroicon-m-chevron-up',
                'panels::sidebar.group.expand-button' => 'heroicon-m-chevron-down',
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
            ])
            ->navigationGroups([
                \Filament\Navigation\NavigationGroup::make()
                     ->label('Inventario')
                     ->icon('heroicon-o-archive-box'),
                \Filament\Navigation\NavigationGroup::make()
                    ->label('Operaciones')
                    ->icon('heroicon-o-cog-8-tooth'),
                \Filament\Navigation\NavigationGroup::make()
                    ->label('Administración')
                    ->icon('heroicon-o-shield-check'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
