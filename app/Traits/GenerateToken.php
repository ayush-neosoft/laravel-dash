<?php

namespace App\Traits;

use App\Utils\AppConstant;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

trait GenerateToken
{
    protected $token = null;
    protected $accessToken = null;

    /**
     * @param object $user
     * 
     * @return string $accessToken
     */
    protected function getToken($user)
    {
        $customClaims = ['uuid' => $user->uuid, 'user_detail_id' => $user->userDetail->id];
        $payload = JWTFactory::sub($customClaims)->make();
        $this->token = JWTAuth::encode($payload);
        $this->accessToken = $this->token->get();
        if (!$this->accessToken) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message', __('jwt.jwt_not_got'));
            return response()->json($this->setResponse(), AppConstant::BAD_REQUEST);
        }

        return $this->accessToken;
    }
}
