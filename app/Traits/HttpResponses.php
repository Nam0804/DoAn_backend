<?php

namespace App\Traits;

trait HttpResponses
{
    public function success($data, $code = 200, $message = null)
    {
        return response()->json(
        [
         'data' => $data,
         'status' => true,
         'message' => $message,

        ], $code);
    }
    public function error($message = null, $code, $data)
    {
        return response()->json(
        [
         'data' => $data,
         'status' => false,
         'message' => $message,

        ], $code);
    }
}