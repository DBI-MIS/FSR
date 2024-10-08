<?php

namespace App\Infolists\Components;

use Filament\Infolists\Components\Component;

class FsrView extends Component
{
    protected string $view = 'infolists.components.fsr-view';

    public static function make(): static
    {
        return app(static::class);
    }
}
