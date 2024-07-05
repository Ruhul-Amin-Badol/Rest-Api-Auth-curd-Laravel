<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function SentResponse($result, $message)
    {

        $response = [
            'success'   => true,
            'data'      => $result,
            'message'   => $message,

        ];
        return response()->json($response, 200);
    }


    public function SendError($error, $errorMessage = [], $code = 404)
    {
        $respones = [
            'success'    => false,
            'message'    => $error,

        ];
        if (!empty($errorMessage)) {
            $respones['data'] = $errorMessage;
        }
        return response()->json($respones, $code);
    }
}
