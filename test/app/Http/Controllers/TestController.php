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
        Log::info('📂 Uploaded files:', array_keys($request->allFiles()));
       // dd($request->all());
        Log::info('🔥 Incoming form request received');
        Log::info('Form fields:', $request->allFiles());

        if ($request->hasFile('VoucherImage')) {
            Log::info('✅ Image received');
            Log::info($request->file('VoucherImage')->getClientOriginalName());
        }

//        return response()->json([
//            'message' => '✅ Request processed'
//        ]);
        return response()->json([
            'message' => 'Form data received successfully ✅',
            'data' => [
                'voucher_image' => $request->input('voucher_image'),
                'user_id' => $request->input('user_id'),
            ],
        ]);
    }
}
