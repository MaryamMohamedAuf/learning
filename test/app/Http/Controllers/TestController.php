<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        // Log incoming request
        Log::info('🔥 Incoming request received');

        return response()->json([

            'data from return endpoint ' => [
                'body' => $request->all(),          // all body params
                'query' => $request->query(),        // URL parameters
                'headers' => $request->headers->all(), // request headers
                'bearer_token' => $request->bearerToken(),  // Authorization Bearer
                'files' => $request->allFiles(),     // uploaded files
            ],
        ]);
    }
}
