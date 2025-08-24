<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {

        // ✅ Log full incoming request (form fields + files separately)
        Log::info('🔥 Incoming form request received');

        // Logs all form fields (text fields, not files)
        Log::info('📋 Form field values:', $request->except(['VoucherImage'])); // filtering

        // Logs file field keys only

        Log::info('Form fields:', $request->allFiles());


        return response()->json([
            'message' => 'Form data received successfully ✅',
            'data' => [
                'customer_id' => $request->input('customer_id'),
                'pin_code' => $request->input('pin_code'),
              //  'file' => $request->file('file')
            ],
        ]);
    }
}
