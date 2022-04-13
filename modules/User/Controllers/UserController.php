<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Models\User;
use Modules\User\Requests\AuthRequest;
use Modules\User\Requests\EmailRequest;
use Modules\User\Requests\UserNameRequest;
use Modules\User\Requests\UserRequest;
use Modules\User\Resources\UserResource;
use Modules\User\Services\UserService;

/**
 *  @OA\Tag(
 *      name="User",
 *      description="User Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="user",
 *      @OA\Property(
 *          property="name",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="number",
 *          example=1,
 *      ),
 *  )
 *
 *  @OA\Schema(
 *      schema="auth",
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          example="123456",
 *      ),
 *  )
 */
class UserController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Login user.
     *
     * @return UserResource
     *
     *  @OA\Post(
     *      path="/api/login",
     *      tags={"User"},
     *      operationId="loginUser",
     *      summary="Login User",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/auth"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Logged in",
     *      ),
     *  )
     */
    public function login(AuthRequest $request)
    {
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Email/Password do not match'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken($user->email)->accessToken;

        return response()->json(['access_token' => $token]);
    }

    /**
     * Register user.
     *
     * @return UserResource
     *
     *  @OA\Post(
     *      path="/api/register",
     *      tags={"User"},
     *      operationId="registerUser",
     *      summary="Register User",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/auth"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Register",
     *      ),
     *  )
     */
    public function register(UserRequest $request)
    {
        $data = $request->only('email', 'company_name', 'business_type', 'business_stage', 'company_size', 'founding_date', 'start_tax_settlement', 'end_tax_settlement');
        $data['password'] = bcrypt($request->password);

        $user = $this->userService->create($data);

        return new UserResource($user);
    }

    /**
     * Get auth user info.
     *
     * @return UserResource
     *
     *  @OA\Get(
     *      path="/api/me",
     *      tags={"User"},
     *      operationId="getProfileUser",
     *      summary="Get Auth User",
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *      ),
     *  )
     */
    public function getProfile()
    {
        $user = auth()->guard('api')->user();
        $user->load('notifications');

        return new UserResource($user);
    }

    /**
     * Logout user.
     *
     * @return Response
     *
     *  @OA\Post(
     *      path="/api/logout",
     *      tags={"User"},
     *      operationId="logoutUser",
     *      summary="Logout User",
     *      @OA\Response(
     *          response=204,
     *          description="Logged out",
     *      ),
     *  )
     */
    public function logout()
    {
        $user = auth()->guard('api')->user();

        $user->token()->revoke();

        return response()->json(null, 204);
    }

    /**
     * Send contact mail.
     */
    public function sendContactEmail(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'sender_name' => 'required',
            'sender_email' => 'required|email',
            'category' => 'required',
            'title' => 'required',
        ]);
        $data = $request->only(['company_name', 'sender_name', 'sender_email', 'category', 'title', 'detail']);
        try {
            dispatch(new SendEmail('mail.contact', $data, config('mail.contact'), 'Contact email'));

            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * update User Login.
     */
    public function setting(Request $request)
    {
        $user = auth()->guard('api')->user();
        $update = $user->id . ',id';
        $request->validate(
            [
                'business_type' => 'required|integer',
                'business_stage' => 'required|integer',
                'company_size' => 'required|integer',
                'company_name' => 'required|max:255',
                'founding_date' => 'required|integer',
                'start_tax_settlement' => 'required|integer',
                'end_tax_settlement' => 'required|integer',
                'email' => 'required|max:255|email|unique:users,email,' . $update,
            ],
            [
                'email.unique' => 'このメールアドレスは使用できません。他のアドレスを指定してください。',
            ]
        );
        $data = $request->only(
            'email',
            'company_name',
            'business_type',
            'business_stage',
            'company_size',
            'founding_date',
            'start_tax_settlement',
            'end_tax_settlement'
        );

        if ($request->has('password')) {
            $request->validate([
                'password' => 'required|min:8|max:255|confirmed|regex:/^(?=.*[a-z])(?=.*\d)[a-z\d]*$/u',
            ]);

            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Check unique email.
     *
     * @return Response
     */
    public function checkEmailUnique(EmailRequest $request)
    {
        return response()->json(null, 204);
    }

    /**
     * Check unique user name.
     *
     * @return Response
     */
    public function checkUserNamelUnique(UserNameRequest $request)
    {
        return response()->json(null, 204);
    }
}
