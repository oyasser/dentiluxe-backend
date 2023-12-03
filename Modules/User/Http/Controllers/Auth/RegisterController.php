<?php

namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Modules\User\Http\Requests\Auth\RegisterRequest;
use Modules\User\Models\User;
use Modules\User\Transformers\UserResource;

class RegisterController extends Controller
{
    private LoginController $loginController;

    public function __construct(LoginController $loginController)
    {
        $this->loginController = $loginController;
    }

    public function register(RegisterRequest $request): array
    {
        $user = User::create($request->validated());

        $accessToken = $this->loginController->getAccessToken($request->email, $request->password);

        $userData = collect(new UserResource($user))->toArray();

        $userData['api_token'] = $accessToken;

        return $userData;
    }
}
