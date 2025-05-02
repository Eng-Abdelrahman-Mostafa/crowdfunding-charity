<?php

namespace App\DTOs;

use Illuminate\Http\JsonResponse;

class JsonResponseDTO
{
    public $success;
    public $message;
    public $data;
    public $code;

    public function __construct($success, $message = null, $data = null, $code = 200)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->code = $code;
    }

    public function toArray()
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'code' => $this->code,
        ];
    }

    public static function success($message = null, $data = null, $code = 200)
    {
        return new self(true, $message, $data, null, $code);
    }

    public static function error($message = null, $errors = null, $code = 400)
    {
        return new self(false, $message, null, $errors, $code);
    }
}
