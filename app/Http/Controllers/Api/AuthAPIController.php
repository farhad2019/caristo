<?php

namespace App\Http\Controllers\Api;

use App\Helper\Utils;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Api\ForgotPasswordCodeRequest;
use App\Http\Requests\Api\LoginAPIRequest;
use App\Http\Requests\Api\RegistrationAPIRequest;
use App\Http\Requests\Api\SocialLoginAPIRequest;
use App\Http\Requests\Api\UpdateChangePasswordRequest;
use App\Http\Requests\Api\UpdateForgotPasswordRequest;
use App\Http\Requests\Api\UpdateUserProfileRequest;
use App\Http\Requests\Api\VerifyCodeRequest;
use App\Models\SocialAccount;
use App\Models\User;
use App\Models\UserDetail;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\UdeviceRepository;
use App\Repositories\Admin\UserdetailRepository;
use App\Repositories\Admin\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthAPIController extends AppBaseController
{

    protected $userRepository, $userDetailRepository, $uDevice, $categoryRepo;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    /**
     * AuthAPIController constructor.
     * @param UserRepository $userRepo
     * @param UserdetailRepository $userdetailRepo
     * @param UdeviceRepository $udeviceRepo
     * @param CategoryRepository $categoryRepo
     */
    public function __construct(
        UserRepository $userRepo,
        UserdetailRepository $userdetailRepo,
        UdeviceRepository $udeviceRepo,
        CategoryRepository $categoryRepo
    )
    {
        $this->userRepository = $userRepo;
        $this->userDetailRepository = $userdetailRepo;
        $this->uDevice = $udeviceRepo;
        $this->categoryRepo = $categoryRepo;
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
            $userDetails['country_code'] = $request->country_code;
            $userDetails['phone'] = $request->phone;
            $userDetails['address'] = isset($request->address) ? $request->address : null;
            $userDetails['image'] = isset($request->image) ? $request->image : null;
            $userDetails['email_updates'] = isset($request->email_updates) ? $request->email_updates : 1;

            if (isset($request->image)) {
                $file = $request->file('image');
                $userDetails['image'] = Storage::putFile('users', $file);
            }

            $this->userDetailRepository->create($userDetails);

            // check if device token exists in incomign  params
            if (isset($request->device_token) && isset($request->device_token)) {
                // check if device token exists
                if ($this->uDevice->getByDeviceToken($request->device_token)) {
                    $this->uDevice->deleteByDeviceToken($request->device_token);
                }

                $deviceData['user_id'] = $user->id;
                $deviceData['device_token'] = $request->device_token;;
                $deviceData['device_type'] = $request->device_type;
                $deviceData['push_notification'] = isset($request->push_notification) ? $request->push_notification : 1;

                $this->uDevice->create($deviceData);

            }

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
            //return $this->sendErrorWithData("Invalid Login Credentials", 403, $e);
            return $this->sendError('Internal Server Error', 500);
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
    public function login(LoginAPIRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

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

    /**
     * @SWG\Post(
     *      path="/social-login",
     *      summary="Login With Social Account.",
     *      tags={"Authorization"},
     *      description="Login With Social Account.",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Login With Social Account.",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SocialAccounts")
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
     *                  ref="#/definitions/SocialAccounts"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function socialLogin(SocialLoginAPIRequest $request)
    {
        $input = $request->all();
        $account = SocialAccount::where(['platform' => $input['platform'], 'client_id' => $input['client_id'], 'deleted_at' => null])->first();
        $user = false;
        $dev_msg = "User login successfully";

        if ($this->uDevice->getByDeviceToken($request->device_token)) {
            $this->uDevice->deleteByDeviceToken($request->device_token);
        }
        if ($account && $account->user) {
            // Account found. generate token;
            $user = $account->user;

        } else {
            // Check if email address already exists. if yes, then link social account. else register new user.
            if (isset($input['email'])) {
                $user = User::query()->where('email', $input['email'])->first();
            }

            if (!$user) {
                // Register user with only social details and no password.
                $userData = [];
                $userData['email'] = $request->input('email',
                    config("app.name") . "." . $request->input('client_id') . "@" . $request->input('platform') . ".com"
                );
                $userData['name'] = $request->input('username', "");
                $userData['password'] = config("app.name");
                $user = User::create($userData);
                $userDetails['user_id'] = $user->id;
                $userDetails['phone'] = $request->input('phone', null);
                UserDetail::create($userDetails);

            }

            // Add social media link to the user
            $account = new SocialAccount();
            $account->user_id = $user->id;
            $account->platform = $input['platform'];
            $account->client_id = $input['client_id'];
            $account->token = $request->input('token', null);
            $account->email = $request->input('email', null);
            $account->username = $request->input('username', null);
            $account->expires_at = $request->input('expires_at', null);
            $account->save();
        }

        $user->name = $request->input('username', null);
        $user->save();

        $deviceData['user_id'] = $user->id;
        $deviceData['device_token'] = $request->input('device_token', null);
        $deviceData['device_type'] = $request->device_type;
        $this->uDevice->create($deviceData);

        $details = UserDetail::where('user_id', $user->id)->first();
        $details->social_login = 1;
        if ($request->hasFile('image')) {
            $mediaFile = $request->file('image');
            $media = Utils::handlePicture($mediaFile, 'profiles');
            $details->image = $media['filename'];
        } else {
            $details->image = $request->input('image', null);
        }
        $details->first_name = $request->input('username', null);
        $details->save();

        if (!$token = \JWTAuth::fromUser($user)) {
            return $this->sendErrorWithData('Invalid credentials, please try login again');
        }

        return $this->respondWithToken($token);
    }


    /**
     * @SWG\Post(
     *      path="/change-password",
     *      summary="Reset password.",
     *      tags={"Authorization"},
     *      description="Reset password.",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="old_password",
     *          description="old password",
     *          type="string",
     *          required=true,
     *          in="formData"
     *      ),@SWG\Parameter(
     *          name="password",
     *          description="new password",
     *          type="string",
     *          required=true,
     *          in="formData"
     *      ),@SWG\Parameter(
     *          name="password_confirmation",
     *          description="confirm password",
     *          type="string",
     *          required=true,
     *          in="formData"
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
    public function changePassword(UpdateChangePasswordRequest $request)
    {
        $old_password = $request->get('old_password');
        $password = $request->get('password');
        $user = \Auth::user();

        $credentials = [
            'email'    => $user->email,
            'password' => $old_password
        ];
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return $this->sendErrorWithData("Wrong Old Password", 403);
        } else {
            $postData = [];
            $postData['password'] = bcrypt($password);
            try {
                $user = $this->userRepository->update($postData, $user->id);
                return $this->sendResponse(['user' => $user], 'Password Changed');
            } catch (\Exception $e) {
                return $this->sendErrorWithData($e->getMessage(), 403);
            }
        }
    }


    /**
     * @SWG\Post(
     *      path="/update-profile",
     *      summary="Reset password.",
     *      tags={"Authorization"},
     *      description="Reset password.",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="name",
     *          description="Full Name of User",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),@SWG\Parameter(
     *          name="country_code",
     *          description="Country Code of User's Phone (like 966, 971)",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),@SWG\Parameter(
     *          name="phone",
     *          description="Phone Number of User's Phone",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),@SWG\Parameter(
     *          name="about",
     *          description="About Me/Bio of User ",
     *          type="string",
     *          required=false,
     *          in="formData"
     *      ),
     *     @SWG\Parameter(
     *          name="image",
     *          description="Image File of the user",
     *          type="file",
     *          required=false,
     *          in="formData"
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
    public function updateUserProfile(UpdateUserProfileRequest $request)
    {
        $user = \Auth::user();
        $userData = array_filter($request->only(['name']));
        $details = $request->only(['country_code', 'phone', 'about']);

        if ($request->hasFile('image')) {
            $mediaFile = $request->file('image');
            $media = Utils::handlePicture($mediaFile, 'profiles');
            $details['image'] = $media['filename'];
        }

        if (count($userData) > 0) {
            if (!empty($userData['name'])) {
                $details['first_name'] = $userData['name'];
            }
            $this->userRepository->update($userData, $user->id);
        }

        if (count($details) > 0) {
//            if (!empty($details['phone'])) {
//                $details['phone'] = $details['country_code'] . $details['phone'];
//                unset($details['country_code']);
//            }
            $this->userDetailRepository->update($details, $user->details->id);
        }

        return $this->sendResponse(['user' => $this->userRepository->findWithoutFail($user->id)->toArray()], 'Profile Updated Successfully');

    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/favorite-news",
     *      summary="Get a listing of the favorite news.",
     *      tags={"Authorization"},
     *      description="Get a listing of the favorite news",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *     @SWG\Parameter(
     *          name="locale",
     *          description="Response Language",
     *          type="string",
     *          default="en",
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="category_id",
     *          description="Category ID if you need favorites for specific category",
     *          type="integer",
     *          required=false,
     *          default=0,
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
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/News")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function favoriteNewsIndex(Request $request)
    {
        \App::setLocale($request->get('locale', 'en'));
        // Implement apply() method.
        $categories = $this->userRepository->findFavoriteNews($request, $this->categoryRepo);
        return $this->sendResponse($categories, 'Favorite News retrieved successfully');
    }


}