<?php

namespace Modules\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     *
     * @param Request $request
     */
    public function sendResetLink(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        Password::broker('admins')->sendResetLink($request->only('email'));

        return response()->json(['message' => 'Reset link sent successfully, please check your email']);
    }

    public function generateResetURL($token): Redirector|Application|RedirectResponse
    {
        $email = \request()->get('email');

        $user = Password::broker('admins')->getUser(['email' => $email]);

        $frontendUrl = config('app.frontend_admin_url');

        return ($user && Password::tokenExists($user, $token)) ?
            redirect($frontendUrl . '/' . config('app.frontend_valid_reset_page')  . $token . '/' . $email) :
            redirect($frontendUrl . '/' . config('app.frontend_invalid_reset_page'));
    }
}
