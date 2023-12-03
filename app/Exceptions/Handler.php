<?php

namespace App\Exceptions;

use App\Traits\ResponseBuilder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Modules\PromoCode\Exceptions\PromocodeAlreadyUsedByUserException;
use Modules\PromoCode\Exceptions\PromocodeBoundToOtherUserException;
use Modules\PromoCode\Exceptions\PromocodeDoesNotExistException;
use Modules\PromoCode\Exceptions\PromocodeExpiredException;
use Modules\PromoCode\Exceptions\PromocodeIsLessThanMinimum;
use Modules\PromoCode\Exceptions\PromocodeIsLessThanMinPrice;
use Modules\PromoCode\Exceptions\PromocodeIsLessThanMinQty;
use Modules\PromoCode\Exceptions\PromocodeNoUsagesLeftException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseBuilder;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        return match (true) {
            $e instanceof ModelNotFoundException => $this->returnError(404, trans('messages.exception.404')),
            $e instanceof PostTooLargeException => $this->returnError(413, trans('messages.exception.413')),
            $e instanceof AuthorizationException, $e instanceof HttpException && $e->getStatusCode() == '403' => $this->returnError(403, trans('messages.exception.403')),
            $e instanceof PromocodeDoesNotExistException, $e instanceof PromocodeNoUsagesLeftException, $e instanceof PromocodeBoundToOtherUserException => $this->returnError(422, trans('promocode::messages.code_invalid'), ['code' => []]),
            $e instanceof PromocodeExpiredException => $this->returnError(422, trans('promocode::messages.code_expired'), ['code' => []]),
            $e instanceof PromocodeAlreadyUsedByUserException => $this->returnError(422, trans('promocode::messages.code_redeemed'), ['code' => []]),
            $e instanceof PromocodeIsLessThanMinPrice => $this->returnError(422, trans('promocode::messages.code_less_than_min_price'), ['code' => []]),
            $e instanceof PromocodeIsLessThanMinQty => $this->returnError(422, trans('promocode::messages.code_less_than_min_qty'), ['code' => []]),
            default => parent::render($request, $e),
        };
    }
}
