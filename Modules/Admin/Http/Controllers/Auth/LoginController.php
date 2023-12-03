<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Exception;

use Laravel\Passport\Client;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Admin\Models\Admin;
use Modules\Admin\Transformers\AdminResource;
use Modules\User\Models\User;
use Modules\User\Http\Requests\Auth\LoginRequest;
use Modules\User\Transformers\UserResource;

class LoginController extends Controller
{
    public function login(LoginRequest $request): array|JsonResponse
    {
        try {
            $email = $request->email;
            $password = $request->password;

            $admin = $this->getAdmin($email);

            $accessToken = $this->getAccessToken($email, $password);

            $adminData          = collect(new AdminResource($admin))->toArray();

            $adminData['api_token']   = $accessToken;
            $adminData['permissions'] = $admin->getAllPermissions();

            return $adminData;
        } catch (Exception $e) {
            return response()->json(['error' => 'Invalid email or password.'], 422);
        }
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    protected function getAccessToken($email, $password): mixed
    {
        $client = $this->getAuthClientAdmin();

        $response = $this->sendCurlRequest($client, $email, $password);

        return json_decode($response)->access_token;
    }

    /**
     * @param mixed $email
     * @return mixed
     */
    protected function getAdmin(mixed $email): mixed
    {
        return Admin::whereEmail($email)->firstOrFail();
    }

    /**
     * @return mixed
     */
    protected function getAuthClientAdmin(): mixed
    {
        return Client::where(['personal_access_client' => 0, 'provider' => 'admins'])->firstOrFail();
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
}
