<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Api\ForgotPasswordCodeRequest;
use App\Http\Requests\Api\RegistrationAPIRequest;
use App\Http\Requests\Api\UpdateForgotPasswordRequest;
use App\Http\Requests\Api\VerifyCodeRequest;
use App\Repositories\Admin\UdeviceRepository;
use App\Repositories\Admin\UserdetailRepository;
use App\Repositories\Admin\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthAPIController extends AppBaseController
{

    protected $userRepository, $userDetailRepository, $uDevice;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepo, UserdetailRepository $userdetailRepo, UdeviceRepository $udeviceRepo)
    {
        $this->userRepository = $userRepo;
        $this->userDetailRepository = $userdetailRepo;
        $this->uDevice = $udeviceRepo;
//        $this->middleware('auth:api', ['except' => ['login']]); //
    }

    /**
     * @SWG\Post(
     *      path="/register",
     *      summary="Register a new user.",
     *      tags={"Authorization"},
     *      description="Register User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Register")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Register"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function register(RegistrationAPIRequest $request)
    {
        try {
            $userDetails = [];
            $postData = [];
            $postData['name'] = ucwords($request->name);
            $postData['email'] = $request->email;
            $postData['password'] = bcrypt($request->password);

            $user = $this->userRepository->create($postData);

            $userDetails['user_id'] = $user->id;
            $userDetails['first_name'] = ucwords($request->name);
            $userDetails['phone'] = $request->phone;
            $userDetails['address'] = isset($request->address) ? $request->address : null;
            $userDetails['image'] = isset($request->image) ? $request->image : null;
            $userDetails['email_updates'] = isset($request->email_updates) ? $request->email_updates : 1;

            if (isset($request->image)) {
                $file = $request->file('image');
                $userDetails['image'] = Storage::putFile('users', $file);
            }

            $this->userDetailRepository->create($userDetails);

            // check if device token exists
            if ($this->uDevice->getByDeviceToken($request->device_token)) {
                $this->uDevice->deleteByDeviceToken($request->device_token);
            }

            $deviceData['user_id'] = $user->id;
            $deviceData['device_token'] = $request->device_token;;
            $deviceData['device_type'] = $request->device_type;
            $deviceData['push_notification'] = isset($request->push_notification) ? $request->push_notification : 1;

            $this->uDevice->create($deviceData);

            $user->roles()->attach([3]);
            $user->save();

            $credentials = [
                'email'    => $request->email,
                'password' => $request->password
            ];

            if (!$token = auth()->guard('api')->attempt($credentials)) {
                return $this->sendErrorWithData("Invalid Login Credentials", 403);
            }

            return $this->respondWithToken($token);

//            $token = JWTAuth::attempt($credentials);
//            $token = auth()->guard('api')->attempt($credentials);
//            $userById = $this->userRepository->find($user->id);
//
//            $userById = $userById->toArray();
            /*DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);
              $subject = "Please verify your email address.";
              Mail::send('email.verify', ['name' => $name, 'verification_code' => $verification_code],
                  function($mail) use ($email, $name, $subject){
                      $mail->from(getenv('FROM_EMAIL_ADDRESS'), "From User/Company Name Goes Here");
                      $mail->to($email, $name);
                      $mail->subject($subject);
                  });*/
//            return $this->sendResponse(['user' => $userById, 'token' => $token], 'User Registered successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorWithData("Invalid Login Credentials", 403, $e);
            //return $this->sendError('Internal Server Error', 500);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *      path="/login",
     *      summary="Login a user.",
     *      tags={"Authorization"},
     *      description="Login User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Login")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Login"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->guard('api')->attempt($credentials)) {
//        if (!$token = auth()->attempt($credentials)) {
            return $this->sendErrorWithData("Invalid Login Credentials", 403);
//            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *      path="/me",
     *      summary="user profile.",
     *      tags={"Authorization"},
     *      description="user profile.",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function me()
    {
        return $this->sendResponse(auth()->user(), 'My Profile');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     * @SWG\Post(
     *      path="/refresh",
     *      summary="refresh auth token.",
     *      tags={"Authorization"},
     *      description="refresh auth token.",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *      path="/logout",
     *      summary="logout user.",
     *      tags={"Authorization"},
     *      description="logout user.",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function logout()
    {
        auth()->guard('api')->logout();

        return $this->sendResponse([], 'Successfully logged out');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->guard('api')->setToken($token)->user()->toArray();
        $user = array_merge($user, [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->guard('api')->factory()->getTTL() * 60
        ]);
        return $this->sendResponse(['user' => $user], 'Logged in successfully');
    }

    /**
     * @SWG\Get(
     *      path="/forget-password",
     *      summary="Forget password request.",
     *      tags={"Authorization"},
     *      description="Register User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="email",
     *          description="User email",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getForgetPasswordCode(ForgotPasswordCodeRequest $request)
    {
        $user = $this->userRepository->getUserByEmail($request->email);
        if (!$user) {
            return $this->sendErrorWithData("Your email address was not found.", 403);
        }

        $code = rand(1111, 9999);

        $subject = "Forgot Password Verification Code";
        try {
            $email = $user->email;
            $name = $user->name;

            $check = DB::table('password_resets')->where('email', $email)->first();
            if ($check) {
                DB::table('password_resets')->where('email', $email)->delete();
            }

            DB::table('password_resets')->insert(['email' => $email, 'code' => $code, 'created_at' => Carbon::now()]);
            Mail::send('email.verify', ['name' => $user->name, 'verification_code' => $code],
                function ($mail) use ($email, $name, $subject) {
                    $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
                    $mail->to($email, $name);
                    $mail->subject($subject);
                });
        } catch (\Exception $e) {
            return $this->sendErrorWithData($e->getMessage(), 403);
        }
        return $this->sendResponse([], 'Verification Code Send To Your Email');
    }

    /**
     * @SWG\Post(
     *      path="/verify-reset-code",
     *      summary="verify forget password request code.",
     *      tags={"Authorization"},
     *      description="verify code",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="verification_code",
     *          description="verification code",
     *          type="integer",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function verifyCode(VerifyCodeRequest $request)
    {
        $code = $request->verification_code;

        $check = DB::table('password_resets')->where('code', $code)->first();
        if (!is_null($check)) {
            $data['email'] = $check->email;
            $data['code'] = "valid";
//            DB::table('password_resets')->where('code', $check->email)->delete();
            return $this->sendResponse(['user' => $data], 'Verified');
        } else {
            return $this->sendErrorWithData('Code Is Invalid', 403);
        }
    }

    /**
     * @SWG\Post(
     *      path="/reset-password",
     *      summary="Reset password.",
     *      tags={"Authorization"},
     *      description="Reset password.",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="email",
     *          description="user email ",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="verification_code",
     *          description="verification code",
     *          type="integer",
     *          required=true,
     *          in="query"
     *      ),@SWG\Parameter(
     *          name="password",
     *          description="new password",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),@SWG\Parameter(
     *          name="password_confirmation",
     *          description="confirm password",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function updatePassword(UpdateForgotPasswordRequest $request)
    {
        $code = $request->verification_code;

        $check = DB::table('password_resets')->where(['code' => $code, 'email' => $request->email])->first();
        if (!is_null($check)) {
            $postData['password'] = bcrypt($request->password);
            try {
                $data = $this->userRepository->getUserByEmail($request->email);
                $user = $this->userRepository->update($postData, $data->id);
                DB::table('password_resets')->where(['code' => $code, 'email' => $request->email])->delete();

                return $this->sendResponse(['user' => $user], 'Password Changed');
            } catch (\Exception $e) {
                return $this->sendErrorWithData($e->getMessage(), 403);
            }
        } else {
            return $this->sendErrorWithData('Code Is Invalid', 403);
        }
    }
}