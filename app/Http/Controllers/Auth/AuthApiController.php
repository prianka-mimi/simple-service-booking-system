<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Manager\Traits\CommonResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserDetailsResource;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    use CommonResponse;

    final public function register(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = (new User())->storeUser($request);
            $token = $user->createToken('auth_token')->plainTextToken;

            $this->data = [
                'token' => $token,
                'user' => new UserDetailsResource($user),
            ];
            $this->status = true;
            $this->status_message = 'User Registration Successful';
            $this->status_code = $this->status_code_success;
        } catch (Throwable $throwable) {
            $this->status = false;
            $this->status_message = 'Failed! ' . $throwable->getMessage();
            $this->status_code = $this->status_code_failed;
            $this->status_class = 'failed';
            app_error_log('REGISTRATION_FAILED', $throwable, 'error');
        }

        return $this->commonApiResponse();
    }

    final public function login(LoginRequest $request): JsonResponse
    {
        if ($request->has('email') && $request->has('password')) {

            if ($request->input('email')) {
                $column = 'email';
            }

            $user = (new User())->get_user_by_column($column, $request->input('email'));
            if ($user && Hash::check($request->input('password'), $user->password)) {

                $this->data           = [
                    'token' => $user->createToken('alter')->plainTextToken,
                    'user'  => new UserDetailsResource($user),
                ];
                $this->status_message = __('Login successful');
            } else {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
        } else {
            throw ValidationException::withMessages(['email' => 'Invalid Credentials']);
        }

        return $this->commonApiResponse();
    }
}
