<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ResponseService
{
    /**
     * Creates a JSON response with a standardized format.
     *
     * @param string $message  - The message to return in the response.
     * @param bool $state      - The state indicating success or failure.
     * @param int $status      - The HTTP status code for the response.
     * @return JsonResponse
     */
    public static function success( $message,  $data=" " ,  $code = 200): JsonResponse
    {
        return response()->json([
            'massage' => $message,
            'state' => 200,
            'data' =>$data,
        ], $code);
    }



    public static function error(string $message,  $data ="",  $code = 400): JsonResponse
    {
        return response()->json([
            'massage' => $message,
            'state' =>400 ,
            'data' =>$data,
        ], $code);
    }
    public static function validation(string $message,  $data="" ,  $code = 500): JsonResponse
    {
        return response()->json([
            'massage' => $message,
            'state' =>500 ,
            'data' =>$data,
        ], $code);
    }


}
