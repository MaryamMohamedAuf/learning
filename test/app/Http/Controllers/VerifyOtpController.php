<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VerifyOtpController extends Controller
{
    /**
     * Mock verify OTP and create order API endpoint
     * Returns successful order creation response
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            "data" => [
                "order" => [
                    "id" => 10598629,
                    "user_id" => 2480471,
                    "amount" => 121,
                    "tax" => 12,
                    "totalPrice" => 133,
                    "currency" => "EGP",
                    "coupons" => [
                        [
                            "offer" => [
                                "offer_id" => 5975,
                                "offer_title" => "خصم 32%  فى بطاطس آند زلابيا"
                            ],
                            "type_prices" => [
                                [
                                    "type_price_id" => 1264540,
                                    "type_price_name" => "كوبون زلابيا بلس وسط",
                                    "coupons" => [
                                        [
                                            "coupon" => "4517118177",
                                            "expire_date" => "2023-03-01"
                                        ]
                                    ]
                                ],
                                [
                                    "type_price_id" => 1264541,
                                    "type_price_name" => "كوبون ميكس زلابيا بلس كبير",
                                    "coupons" => [
                                        [
                                            "coupon" => "4346414633",
                                            "expire_date" => "2023-03-01"
                                        ],
                                        [
                                            "coupon" => "1234434610",
                                            "expire_date" => "2023-03-01"
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "morePage" => false
            ],
            "status" => 200
        ], 200);
    }
} 