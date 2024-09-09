<?php

namespace App\Infolists\Components;

use Filament\Infolists\Components\Component;

class ViewDbeDirectory extends Component
{
    protected string $view = 'infolists.components.view-dbe-directory';

    public static function make(): static
    {
        return app(static::class);
    }
}
