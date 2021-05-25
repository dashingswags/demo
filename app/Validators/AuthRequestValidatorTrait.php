<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait AuthRequestValidatorTrait
{

    private function validateUserSignup(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'name' => 'required',
            'email' => 'email|unique:users',
            'password' => 'required|confirmed'
        ];
        return Validator::make($request->all(), $rules);
    }

    private function validateUserLogin(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'email' => 'email|required',
            'password' => 'required'
        ];
        return Validator::make($request->all(), $rules);
    }

}
