<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class CartException extends Exception
{
    use ResponseBuilder;

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request
     * @return JsonResponse
     */
    public function render($request): JsonResponse
    {
        return $this->returnSuccess($this->message, ['items' => []]);
    }
}
