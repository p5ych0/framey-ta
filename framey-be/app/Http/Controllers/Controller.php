<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return a success JSON response.
     *
     * @param  string             $message optional
     * @param  array|string|null  $data    optional
     * @param  int                $code    optional
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success(string $message = null, mixed $data = null, ?int $code = Response::HTTP_OK)
    {
        return response()->json([
            'status'  => 'Success',
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string             $message optional
     * @param  array|string|null  $data    optional
     * @param  int                $code    optional
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message = null, mixed $data = null, ?int $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status' => 'Generic Error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
