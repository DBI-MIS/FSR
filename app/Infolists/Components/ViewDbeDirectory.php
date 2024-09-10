<?php

namespace App\Infolists\Components;

use App\Models\DbeDirectory;
use Filament\Infolists\Components\Component;

class ViewDbeDirectory extends Component
{
    protected string $view = 'infolists.components.view-dbe-directory';

    public static function make(): static
    {
        return app(static::class);
    }
    public function show($id)
{
    // Fetch the DbeDirectory with related project and fsrs
    $dbeDirectory = DbeDirectory::with(['directoryproject.fsrs' => function ($query) {
        // Order by latest and limit the number of results
        $query->latest();
    }, 'contactsdbe'])->find($id);

    dd($dbeDirectory);
    return view('infolists.components.view-dbe-directory', [
        'getRecord' => $dbeDirectory,
    ]);
}

}
