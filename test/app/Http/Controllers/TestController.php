<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
       // sleep(5);
       // abort(500);
       // return response()->json(['message' => 'It works!']);

        return response()->json([
          //  "responseObject" => 'done',
            "responseObject" => 'doneت'
        ],200);
    }
}
