<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class ItemException extends Exception
{
    use ResponseBuilder;

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render($request): JsonResponse
    {
        return $this->returnBadRequest($this->message);
    }
}
