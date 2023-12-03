<?php

namespace App\Traits;

use App\Exceptions\CartException;
use App\Exceptions\ItemException;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

trait ResponseBuilder
{
    /**
     * Returned data or errors.
     * @var array
     */
    private array $responseData = [];

    /**
     * Response message.
     * @var string|null
     */
    private ?string $responseMessage = '';

    /**
     * Header codes.
     * @var integer
     */
    private int $header_code;


    /**
     * Return success response.
     * @param string $message
     * @param array $data
     * @param integer $headerCode
     * @return JsonResponse
     */
    public function returnSuccess(string $message = 'success', array $data = [], int $headerCode = 200): JsonResponse
    {
        return $this->setResponseMessage($message)
            ->setResponseData($data)
            ->success($headerCode);
    }

    /**
     * Return bad request response.
     * @param null|string $message
     * @param array $data
     * @return JsonResponse
     */
    public function returnBadRequest(?string $message = '', array $data = []): JsonResponse
    {
        if (empty($message)) {
            $message = trans('messages.exception.400');
        }

        return $this->setResponseMessage($message)
            ->setResponseData($data)
            ->error(400);
    }

    /**
     * Return error response.
     * @param integer $headerCode
     * @param null|string $message
     * @param array $data
     * @return JsonResponse
     */
    public function returnError(int $headerCode, ?string $message = '', array $data = []): JsonResponse
    {
        return $this->setResponseMessage($message)
            ->setResponseData($data)
            ->error($headerCode);
    }

    /**
     * Set response message.
     * @param string|null $message
     * @return Controller|CartException|ItemException|ResponseBuilder
     */
    protected function setResponseMessage(?string $message): self
    {
        $this->responseMessage = $message;

        return $this;
    }

    /**
     * Set response data.
     * @param array $data
     * @return Controller|CartException|ItemException|ResponseBuilder
     */
    protected function setResponseData(array $data): self
    {
        $this->responseData = $data;

        return $this;
    }

    /**
     * Get response message.
     * @return string|null
     */
    protected function responseMessage(): ?string
    {
        return $this->responseMessage;
    }

    /**
     * Get response data.
     * @return array
     */
    protected function responseData(): array
    {
        return $this->formatFloatNumbers($this->responseData);
    }

    /**
     * Format any float number inside the array.
     * @param $data
     * @return array
     */
    private function formatFloatNumbers($data): array
    {
        return collect($data)->map(function ($item) {
            if (is_float($item)) {
                return preg_replace('/\.00/', '', number_format((float) $item, 2, '.', ''));
            } elseif (is_array($item)) {
                return $this->formatFloatNumbers($item);
            }

            return $item;
        })->toArray();
    }

    /**
     * Build error response.
     * @param integer $headerCode
     * @return JsonResponse
     */
    protected function error(int $headerCode): JsonResponse
    {
        $response = [];

        $response['message'] = $this->responseMessage();

        if ($this->responseData()) {
            $response['errors'] = $this->responseData();
        }

        return $this->response($response, $headerCode);
    }

    /**
     * Build success response.
     * @param integer $headerCode
     * @return JsonResponse
     */
    protected function success(int $headerCode): JsonResponse
    {
        $response = [
            'message' => $this->responseMessage(),
            'data'    => $this->responseData(),
        ];

        if (isset($this->responseData()['data'])) {
            $response['data'] = $this->responseData()['data'];
        }

        if (isset($this->responseData()['additionalData'])) {
            $response['additionalData'] = $this->responseData()['additionalData'];
        }

        if (isset($this->responseData()['meta'])) {
            $response['meta'] = $this->responseData()['meta'];
        }

        return $this->response($response, $headerCode);
    }

    /**
     * Prepare returned response.
     * @param array $response [description]
     * @param integer $headerCode [description]
     * @param array $headers
     * @param int $options
     *
     * @SuppressWarnings("StaticAccess")
     *
     * @return JsonResponse
     */
    protected function response(array $response, int $headerCode, array $headers = [], int $options = 0): JsonResponse
    {
        return response()->json($response, $headerCode, $headers, $options);
    }
}
