<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Laravel\Prompts\password;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
       //abort(500);
       //sleep(5);
       return response()->json([
            "responseObject" => [
              'data' =>  'it works',
                'password' => '8888'
            ]
        ])->withHeaders([
            'Content-Type' => 'multipart-form/json',
           'api-key' => 'test',
       ]);
    }
}
