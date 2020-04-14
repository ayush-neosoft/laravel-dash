<?php

namespace App\Http\Controllers\Api\v1\Auth;

use Exception;
use App\Models\User;
use App\Models\UserMeta;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Traits\ApiResponse;
use App\Traits\GenerateToken;
use App\Utils\AppConstant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    use ApiResponse, GenerateToken, VerifiesEmails;

    /**
     *  
     * @param SignupRequest $request
     * @return ApiResponse
     */
    public function register(SignupRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]); 

            $user_meta = UserMeta::create([
                'user_id' => $user->id,
                'device_name' => $request->header('User-Agent'),
                'os' => $request->server('HTTP_USER_AGENT'),
                'ip_address' => $request->ip()
            ]);

            DB::commit();

            $user = User::find($user->id);
            $user->send_api_email_verify_notification();
            $user->meta = $user_meta;
            $user->token = $this->getToken($user);

            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', __('auth.register_success'));
            $this->setData('user', $user);
            return response()->json($this->setResponse(), AppConstant::CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }

    /**
     * Mark the authenticated user’s email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify($user_id) 
    {
        $user = User::find($user_id);
        // check if email verified
        if ($user->hasVerifiedEmail()) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('auth.email_already_verified'));
        } 
        elseif($user->verify()) 
        {
            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', __('auth.email_verify_success'));
        }

        return response()->json($this->setResponse(), AppConstant::OK);
    }

    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resend($user_id)
    {
        $user = User::find($user_id);
        if ($user->hasVerifiedEmail()) 
        {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('auth.email_already_verified'));
            return response()->json($this->setResponse(), AppConstant::OK);
        }

        $user->send_api_email_verify_notification();
        $this->setMeta('status', AppConstant::STATUS_OK);
        $this->setMeta('message', __('auth.email_notification_resent'));
        return response()->json($this->setResponse(), AppConstant::OK);
    }

    /**
     * @param LoginRequest $request
     * 
     * @return ApiResponse
     */
    public function login(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = User::where('email', $request->email)->first();

            // check if email exists
            if (!$user) {
                $this->setMeta('status', AppConstant::STATUS_FAIL);
                $this->setMeta('message', __('auth.email_not_found'));
                return response()->json($this->setResponse(), AppConstant::UNAUTHORIZED);
            }

            // match password
            if (!Hash::check($request->password, $user->password)) {
                $this->setMeta('status', AppConstant::STATUS_FAIL);
                $this->setMeta('message', __('auth.password_incorrect'));
                return response()->json($this->setResponse(), AppConstant::UNAUTHORIZED);
            }

            // check user status
            if (!$user->status) {
                $this->setMeta('status', AppConstant::STATUS_FAIL);
                $this->setMeta('message', __('auth.blocked_login'));
                return response()->json($this->setResponse(), AppConstant::UNAUTHORIZED);
            }

            $user_meta = UserMeta::create([
                'user_id' => $user->id,
                'device_name' => $request->header('User-Agent'),
                'os' => $request->server('HTTP_USER_AGENT'),
                'ip_address' => $request->ip()
            ]);

            $user = User::find($user->id);
            $user->meta = $user_meta;
            $user->token = $this->getToken($user);

            DB::commit();
            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', __('auth.register_success'));
            $this->setData('user', $user);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }

    /**
     *
     * @return ApiResponse
     */
    public function me()
    {
        $token = JWTAuth::getToken();

        try {
            $sub = JWTAuth::getPayload($token)->get('sub');
            $user = User::where('uuid', $sub->uuid)->first();
            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', __('auth.login_success'));
            $this->setData('user', $user);
        } catch (Exception $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::INTERNAL_SERVER_ERROR);
        }

        return response()->json($this->setResponse(), AppConstant::OK);
    }

    /**
     * @return ApiResponse
     */
    public function logout()
    {
        $token = JWTAuth::getToken();

        try {
            DB::beginTransaction();

            $sub = JWTAuth::getPayload($token)->get('sub');
            UserMeta::where('id', $sub->user_meta->id)->delete();
            JWTAuth::invalidate($token);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::INTERNAL_SERVER_ERROR);
        }

        $this->setMeta('status', AppConstant::STATUS_OK);
        $this->setMeta('message', __('jwt.logout_success'));
        return response()->json($this->setResponse(), AppConstant::OK);
    }
}
