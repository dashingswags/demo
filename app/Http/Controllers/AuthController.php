<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Validators\AuthRequestValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{
    use AuthRequestValidatorTrait;

    public function signup(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = $this->validateUserSignup($request);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }
        try {
            DB::beginTransaction();
            $user = UserRepository::registerUser($request);
            DB::commit();
            $accessToken = $user->createToken('authToken')->accessToken;
            return $this->successResponse(['user'=> $user, 'access_token' => $accessToken]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('an error occured : '. $e->getMessage());
        }
    }


    public function login(Request $request): \Illuminate\Http\JsonResponse
    {

        $validator = $this->validateUserLogin($request);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        if (!Auth::attempt($request->all())) {
            return $this->errorResponse('invalid credentials');
        }

        $user = Auth::user();
        $accessToken = $user->createToken('authToken')->accessToken;
        return $this->successResponse(['user'=> $user, 'access_token' => $accessToken]);

    }
}
