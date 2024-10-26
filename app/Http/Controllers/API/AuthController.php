<?php

namespace App\Http\Controllers\API;

use App\Actions\Auth\ForgotPasswordAction;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\Auth\LoginService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(UserRegisterRequest $request, RegisterAction $registerAction)
    {
        $result = $registerAction->handle($request->email, $request->password, $request->name);
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $result
        ], 201);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $loginService = new LoginService($request->email, $request->password);
        $result = $loginService->login();
        return response()->json($result, $result['status'] ?? 200);
    }

    public function admin(UserLoginRequest $request): JsonResponse
    {
        $loginService = new LoginService($request->email, $request->password);
        $loginService->setIsAdmin();
        $result = $loginService->login();
        return response()->json($result, $result['status'] ?? 200);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json(['success' => true, 'message' => 'Logout successfully']);
    }

    public function forgotPassword(ForgotPasswordRequest $request, ForgotPasswordAction $forgotPasswordAction)
    {
        try {
            return $forgotPasswordAction->sendEmail($request->email);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $resetPasswordAction)
    {
        try {
            return $resetPasswordAction->resetPassword($request->jwt, $request->password);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

}
