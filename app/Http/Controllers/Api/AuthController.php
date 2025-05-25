<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Requests\AuthLogin;
use App\Http\Requests\AuthRegister;
use App\Services\AuthService;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authService;

    /**
     * Create a new class instance.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRegister $request)
    {
        try {
            $response = $this->authService->authRegister($request);

            if ($response) {
                return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $response, statusCode: self::SUCCESS);
            }
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::ERROR_MESSAGE, statusCode: self::ERROR);
        } catch (Exception $e) {
            Log::error('Exception occured while registering user', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }


    public function Login(AuthLogin $request)
    {
        try {
            $loginResponse  = $this->authService->authLogin($request);
            if (!$loginResponse) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::ERROR_MESSAGE, statusCode: self::ERROR);
            }
            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $loginResponse, statusCode: self::SUCCESS);
        } catch (Exception $e) {
            Log::error('Exception occured while login user', ['error' => $e->getMessage()]);
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    public function logout()
    {
        try {
            $this->authService->authLogout();
            return ApiResponse::success(
                status: self::SUCCESS_STATUS,
                message: 'Logout berhasil',
                statusCode: self::SUCCESS
            );
        } catch (Exception $e) {
            Log::error('Exception occured while logging out user', ['error' => $e->getMessage()]);
            return ApiResponse::error(
                status: self::ERROR_STATUS,
                message: self::EXCEPTION_MESSAGE,
                statusCode: self::ERROR
            );
        }
    }

    public function me()
    {
        try {
            $user = $this->authService->authMe();
            return ApiResponse::success(
                status: self::SUCCESS_STATUS,
                message: self::SUCCESS_MESSAGE,
                data: $user,
                statusCode: self::SUCCESS
            );
        } catch (Exception $e) {
            Log::error('Exception occured while fetching user info', ['error' => $e->getMessage()]);
            return ApiResponse::error(
                status: self::ERROR_STATUS,
                message: self::EXCEPTION_MESSAGE,
                statusCode: self::ERROR
            );
        }
    }
}