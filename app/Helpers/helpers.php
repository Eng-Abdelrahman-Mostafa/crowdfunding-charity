<?php

use App\DTOs\JsonResponseDTO;
use App\Helpers\FileHelper;
use App\Helpers\ImageHelper;
use hisorange\BrowserDetect\Parser as Browser;
use \Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

if (!function_exists('input')) {
    function input($key = null, $default = null)
    {
        return request($key, $default) ?: $default;
    }
}

//Response Helpers
if (!function_exists('json_response')) {
    function json_response($success, $message = null, $data = null,  $code = 200) : JsonResponse
    {
        $responseDTO = new JsonResponseDTO($success, $message, $data, $code);
        return response()->json($responseDTO->toArray(), $responseDTO->code);
    }
}

if (!function_exists('json_response_dd')) {
    function json_response_dd($success=false, $message = null, $data = null,  $code = 500) : JsonResponse
    {
        $responseDTO = new JsonResponseDTO($success, $message, $data, $code);
        response()->json($responseDTO->toArray(), $responseDTO->code)->throwResponse();
    }
}
if (!function_exists('abort_json')) {
    function abort_json($code, $message = null) : void
    {
        $responseDTO = new JsonResponseDTO(false, $message, null, $code);
        abort(response()->json($responseDTO->toArray(), $responseDTO->code));
    }
}
