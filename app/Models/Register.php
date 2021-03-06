<?php

namespace App\Models;

/**
 * @SWG\Definition(
 *      definition="Register",
 *      required={"name", "email", "address", "image", "password", "password_confirmation","dob","profession","nationality","gender"},
 *      @SWG\Property(
 *          property="name",
 *          description="User First Name",
 *          type="string"
 *      ),@SWG\Property(
 *          property="address",
 *          description="User address",
 *          type="string"
 *      ),@SWG\Property(
 *          property="country_code",
 *          description="User Country code for phone",
 *          type="string"
 *      ),@SWG\Property(
 *          property="phone",
 *          description="User Phone Name",
 *          type="string"
 *      ),@SWG\Property(
 *          property="image",
 *          description="User Image",
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
 *          property="dob",
 *          description="User Date of Birth",
 *          type="string"
 *      ),@SWG\Property(
 *          property="profession",
 *          description="User's Profession Confirmation",
 *          type="string"
 *      ),@SWG\Property(
 *          property="nationality",
 *          description="User's nationality",
 *          type="string"
 *      ),@SWG\Property(
 *          property="gender",
 *          description="User gender 10 = male, 20 = female",
 *          type="integer",
 *          default=10
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
        'email'                 => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
//        'email'                 => 'required|email|unique:users,email',
        'password'              => 'min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'min:6',
        'device_type'           => 'required|in:ios,android,web'
    ];
}