<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class InsuranceDocDownload extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $fileFullPath = $request->file_path;

        if ($fileFullPath != null) {
            // Check if file exists in app/storage/file folder
            if (file_exists($fileFullPath))
            {
                // Send Download
                return Response::download($fileFullPath);
            } else {
                abort(404, 'Requested file does not exist on our server!');
            }
        } else {
            // Error
            abort(404, 'Requested file does not exist on our server!');
        }
    }
}
