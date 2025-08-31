<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'data' => [
                'body' => $request->all(),          // all body params
                'query' => $request->query(),        // URL parameters
                'headers' => $request->headers->all(), // request headers
                'bearer_token' => $request->bearerToken(),  // Authorization Bearer
               // 'files' => $request->allFiles(),     // uploaded files
                'files'   => collect($request->allFiles())->map(fn($f) => [
                    'name'    => $f->getClientOriginalName(),
                    'mime'    => $f->getMimeType(),
                    'size_kb' => round($f->getSize() / 1024, 2),
                ]),
            ],
        ]);
    }
}
