<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponse;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use App\Models\UserDetail;
use App\Traits\GenerateToken;
use App\Utils\AppConstant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponse, GenerateToken;

    protected $user, $userDetail;

    public function __construct()
    {
        $this->user = new User();
        $this->userDetail = new UserDetail();
    }

    /**
     *  @param SignupRequest $request 
     * 
     *  @return ApiResponse
     */
    public function signup(SignupRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->user;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $userDetail = $this->userDetail;
            $userDetail->user_id = $this->user->id;
            $userDetail->device_name = $request->header('User-Agent');
            $userDetail->os = $request->server('HTTP_USER_AGENT');
            $userDetail->ip_address = $request->ip();
            $userDetail->save();

            $this->user->userDetail = $userDetail;
            $user = $this->user->find($this->user->id);
            $user->token = $this->getToken($this->user);

            DB::commit();
            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', __('auth.register_success'));
            $this->setData('user', $user);
            return response()->json($this->setResponse(), AppConstant::CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }

    /**
     * @param LoginRequest $request
     * 
     * @return ApiResponse
     */
    public function signin(LoginRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->user->where([
                'email' => $request->email
            ])->first();

            if (!$user) {
                $this->setMeta('status', AppConstant::STATUS_FAIL);
                $this->setMeta('message', __('auth.login_failed'));
                return response()->json($this->setResponse(), AppConstant::UNAUTHORIZED);
            }

            if (!Hash::check($request->password, $user->password)) {
                $this->setMeta('status', AppConstant::STATUS_FAIL);
                $this->setMeta('message', __('auth.login_failed'));
                return response()->json($this->setResponse(), AppConstant::UNAUTHORIZED);
            }

            if (!$user->status) {
                $this->setMeta('status', AppConstant::STATUS_FAIL);
                $this->setMeta('message', __('auth.blocked_login'));
                return response()->json($this->setResponse(), AppConstant::UNAUTHORIZED);
            }

            if (!$user->is_verified) {
                $this->setMeta('status', AppConstant::STATUS_FAIL);
                $this->setMeta('message', __('auth.unverified_login'));
                return response()->json($this->setResponse(), AppConstant::UNAUTHORIZED);
            }

            $userDetail = $this->userDetail;
            $userDetail->user_id = $user->id;
            $userDetail->device_name = $request->header('User-Agent');
            $userDetail->os = $request->server('HTTP_USER_AGENT');
            $userDetail->ip_address = $request->ip();
            $userDetail->save();

            $user->userDetail = $userDetail;
            $user->token = $this->getToken($user);
            unset($user->userDetail);

            DB::commit();
            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', __('auth.register_success'));
            $this->setData('user', $user);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            DB::rollBack();
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
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
            $this->userDetail->where('id', $sub->user_detail_id)->delete();
            JWTAuth::invalidate($token);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::INTERNAL_SERVER_ERROR);
        }

        $this->setMeta('status', AppConstant::STATUS_OK);
        $this->setMeta('message', __('jwt.logout_success'));
        return response()->json($this->setResponse(), AppConstant::OK);
    }
}
