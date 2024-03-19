<?php
namespace App\Http\Controllers;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticatedSessionController extends FortifyController
{
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): LogoutResponse
    {

        $token = PersonalAccessToken::findToken($request->bearerToken());
        $token->delete();

        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return app(LogoutResponse::class);
    }
}
?>