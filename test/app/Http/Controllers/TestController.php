<?php
//
//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//use function Laravel\Prompts\password;
//
//class TestController extends Controller
//{
//    public function __invoke(Request $request)
//    {
//       //abort(500);
//       //sleep(5);
//       return response()->json([
//            "responseObject" => [
//              'data' =>  'it works',
//                'password' => '8888'
//            ]
//        ])->withHeaders([
//            'Content-Type' => 'multipart-form/json',
//           'api-key' => 'test',
//       ]);
//    }
//}


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
                'user_id' => $request->input('pin_code'),
                'file' => $request->file('file')
            ],
        ]);
    }
}
