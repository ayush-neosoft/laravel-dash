<?php

namespace App\Http\Middleware;

use App\Models\Users;
use App\Traits\ApiResponse;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Utils\AppConstant;

class VerifyJWTToken
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = JWTAuth::getToken();
        if (!$token) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('jwt.jwt_absent'));
            return response()->json($this->setResponse(), AppConstant::BAD_REQUEST);
        }
        try {
            $user = $this->auth($token);
            if (!$user) {
                $this->setMeta('status', AppConstant::STATUS_FAIL);
                $this->setMeta('message', __('jwt.jwt_invalid'));
                return response()->json($this->setResponse(), AppConstant::TOKEN_INVALID);
            }
        } catch (TokenExpiredException $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('jwt.jwt_expire'));
            return response()->json($this->setResponse(), AppConstant::TOKEN_INVALID);
        } catch (TokenInvalidException $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('jwt.jwt_invalid'));
            return response()->json($this->setResponse(), AppConstant::TOKEN_INVALID);
        } catch (JWTException $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('jwt.jwt_invalid'));
            return response()->json($this->setResponse(), AppConstant::TOKEN_INVALID);
        }
        $request->merge(['user' => $user]);
        return $next($request);
    }

    public function auth($token = false)
    {
        $sub = JWTAuth::getPayload($token)->get('sub');

        $tokenIssuedTime = JWTAuth::getPayload($token)->get('iat');
        $user = Users::where([
            'uuid' => $sub['uuid'],
            'status' => AppConstant::STATUS_ACTIVE,
        ])->first();

        if ($user) {
            return $user;
        }
        return false;
    }
}
