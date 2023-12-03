<?php

namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Client;
use Modules\User\Http\Requests\Auth\LoginRequest;
use Modules\User\Models\User;
use Modules\User\Transformers\UserResource;

class LoginController extends Controller
{
    public function login(LoginRequest $request): array|JsonResponse
    {
        try {
            $email = $request->email;
            $password = $request->password;

            $user = $this->getUser($email);

            $accessToken = $this->getAccessToken($email, $password);

            $userData = collect(new UserResource($user))->toArray();

            $userData['api_token'] = $accessToken;

            return $userData;
        } catch (Exception $e) {
            return response()->json(['error' => trans('auth.failed')], 422);
        }
    }

    /**
     * @param mixed $email
     * @return mixed
     */
    protected function getUser(mixed $email): mixed
    {
        return User::where($this->phone(), $email)->firstOrFail();
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function getAccessToken($email, $password): mixed
    {
        $client = $this->getAuthClientUser();

        $response = $this->sendCurlRequest($client, $email, $password);

        return json_decode($response)->access_token;
    }

    /**
     * @return mixed
     */
    protected function getAuthClientUser(): mixed
    {
        return Client::where(['personal_access_client' => 0, 'provider' => 'users'])->firstOrFail();
    }

    /**
     * @param $client
     * @param mixed $email
     * @param mixed $password
     * @return bool|string
     */
    protected function sendCurlRequest($client, mixed $email, mixed $password): string|bool
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => config('app.url') . "/oauth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=password&client_id=" . $client->id . "&client_secret=" . $client->secret . "&username=" . $email . "&password=" . $password,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "content-type: application/x-www-form-urlencoded",
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function phone(): string
    {
        return filter_var(request('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    }
}
