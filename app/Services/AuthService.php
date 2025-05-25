<?php

namespace App\Services;

use App\Repository\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $authRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function authRegister($request)
    {
        $request = $request->all();
        $request['password'] = Hash::make($request['password']);

        return $this->authRepository->registerUser($request);
    }

    public function authLogin($request)
    {
        if (!Auth::attempt([
            'email' => $request['email'],
            'password' => $request['password']
        ])) {
            return false;
        }

        $authUser = Auth::user();
        $token = $authUser->createToken('auth_token')->plainTextToken;

        return [
            'name' => $authUser->name,
            'token' => $token,
        ];
    }


    public function authLogout()
    {
        // Hapus token yang sedang dipakai user (logout current token)
        $user = auth()->user();
        if ($user) {
            $user->currentAccessToken()->delete();
        }
    }

    public function authMe()
    {
        return Auth::user();
    }
}