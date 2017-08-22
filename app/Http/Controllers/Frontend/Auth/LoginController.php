<?php

namespace App\Http\Controllers\Frontend\Auth;

use Exception;
use Socialite;
use App\Http\Controllers\Controller;
use App\Service\GoogleAuthService;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\InvalidParameterException;

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
        try {

            $googleUser = Socialite::driver('google')->user();

            $this->googleAuthService->loginGoogle($googleUser);

            session()->flash('success', 'Login successfuly');
        } catch (InvalidParameterException $ex) {
            session()->flash('error', $ex->getMessage());
        } catch (Exception $ex) {
            session()->flash('error', 'Login failed');
        }

        return redirect()->to(session()->get('url.back-login'));
    }
}