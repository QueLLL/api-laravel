<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendSuccessResponse($message, $code = 200)
    {
        $result['message'] = $message;
        $result['status_code'] = $code;

        return response()->json($result, $code);
    }

    protected function sendErrorResponse($message, $code = 400)
    {
        $result['error_message'] = $message;
        $result['status_code'] = $code;

        return response()->json($result, $code);
    }
}
