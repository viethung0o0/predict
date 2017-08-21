<?php
/**
 * Created by PhpStorm.
 * User: hungpv
 * Date: 21/08/2017
 * Time: 22:49
 */

namespace App\Service;

use App\Repositories\UserRepository;

class GoogleAuthService
{
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function loginGoogle($googleUser)
    {
        $username = $googleUser->getNickname() ?: str_replace(' ', '_', $googleUser->getName() . $googleUser->getId());

        $user = $this->userRepo->firstOrCreate([
            'google_id' => $googleUser->getId()
        ], [
            'name' => $googleUser->getName(),
            'username' => $username,
            'email' => $googleUser->getEmail(),
            'password' => bcrypt($googleUser->getId()),
            'birthday' => null,
            'gender' => $googleUser->user['gender'] ?? null,
            'phone' => null,
            'avatar' => $googleUser->getAvatar(),
            'google_id' => $googleUser->getId()
        ]);

        auth()->login($user);

        return $user;
    }
}