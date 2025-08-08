<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderSummaryController extends Controller
{
    /**
     * Mock order summary API endpoint
     * Returns order summary data
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            [
                "offer_id" => 5975,
                "type_prices" => [
                    [
                        "type_id" => 1264540,
                        "qnt" => 1
                    ],
                    [
                        "type_id" => 1264541,
                        "qnt" => 2
                    ]
                ]
            ]
        ], 200);
    }
} 