<?php

namespace App\Http\Controllers\Frontend\Auth;

use Socialite;
use App\Http\Controllers\Controller;
use App\Service\GoogleAuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $googleAuthService;

    public function __construct(GoogleAuthService $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request)
    {
        $urlPrevious = $request->headers->get('referer');
        session()->flash('url.back-login', $urlPrevious);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $this->googleAuthService->loginGoogle($googleUser);

        return redirect()->to(session()->get('url.back-login'));
    }
}