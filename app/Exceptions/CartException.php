<?php

namespace App\Exceptions;

use App\Traits\ResponseBuilder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
