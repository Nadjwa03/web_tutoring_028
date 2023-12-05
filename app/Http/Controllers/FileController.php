<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function show_pdf(string $filename)
    {
        $path = storage_path('app/uploads/' . $filename);

        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }
}
