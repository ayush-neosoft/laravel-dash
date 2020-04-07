<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Http\Requests\SignupRequest;
use App\Utils\AppConstant;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     *  @param SignupRequest $request 
     * 
     *  @return object
     */
    public function signup(SignupRequest $request)
    {
        try {
            DB::beginTransaction();

            dd($request->all());
            // $request->validated();

            DB::commit();
            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message',  'Request Fetch Successfully.');
            $this->setData('request', $request->all());
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            DB::rollBack();
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }
}
