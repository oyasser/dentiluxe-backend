<?php

namespace App\Exceptions;

use App\Traits\ResponseBuilder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
