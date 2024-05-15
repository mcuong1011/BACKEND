<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

abstract class APIController extends Controller
{
    protected function responseSuccess(array $data)
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
