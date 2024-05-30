<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ImageController extends BaseController
{
    public function show($filename)
    {
        $path = storage_path('app/private/pictures/' . $filename);

        if (!Storage::disk('private')->exists('pictures/' . $filename)) {
            return $this->sendError('Arquivo não encontrado.', [], 404);
        }

        $file = Storage::disk('private')->get('pictures/' . $filename);
        $mimeType = Storage::disk('private')->mimeType('pictures/' . $filename);

        return Response::make($file, 200)->header("Content-Type", $mimeType);
    }
}
