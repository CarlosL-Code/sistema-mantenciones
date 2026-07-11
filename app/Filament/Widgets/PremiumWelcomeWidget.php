<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class PremiumWelcomeWidget extends Widget
{
    protected string $view = 'filament.widgets.premium-welcome-widget';
    protected static ?int $sort = 0;
    protected int | string | array $columnSpan = 'full';
}
