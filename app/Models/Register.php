<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;

/**
 * @SWG\Definition(
 *      definition="Register",
 *      required={"name", "email", "phone", "password", "password_confirmation", "device_token", "device_type"},
 *      @SWG\Property(
 *          property="name",
 *          description="User Full Name",
 *          type="string"
 *      ),@SWG\Property(
 *          property="phone",
 *          description="User Phone Name",
 *          type="string"
 *      ),@SWG\Property(
 *          property="email",
 *          description="User Email",
 *          type="string"
 *      ),@SWG\Property(
 *          property="password",
 *          description="Password",
 *          type="string"
 *      ),@SWG\Property(
 *          property="password_confirmation",
 *          description="Password Confirmation",
 *          type="string"
 *      ),@SWG\Property(
 *          property="device_token",
 *          description="Device Token",
 *          type="string"
 *      ),@SWG\Property(
 *          property="device_type",
 *          description="Device Type",
 *          type="string"
 *      )
 * )
 */
class Register
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'                  => 'required',
        'email'                 => 'required|email|unique:users,email',
        'password'              => 'min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'min:6'
    ];
}