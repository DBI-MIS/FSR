<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class DownloadPdfController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Pdf::view('infolists.components.fsr-view')
        ->download()
        ->format('letter')
        ->save('test.pdf');
    }
}
