<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * Mock transaction API endpoint
     * Returns error response for order not found
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            "message" => "Order not found ",
            "status" => 400
        ], 200);
    }
}
