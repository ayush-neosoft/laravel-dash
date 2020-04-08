<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardDetailRequest;
use App\Models\Plan;
use App\Traits\ApiResponse;
use App\Utils\AppConstant;
use Exception;

class DashboardController extends Controller
{
    use ApiResponse;

    protected $plan;

    public function __construct()
    {
        $this->plan = new Plan();
    }

    public function dashboardPlans(Request $request)
    {
        try {
            $user = $request->user;

            $plans = $this->plan->where([
                'user_id' => $user->id,
                'status' => AppConstant::STATUS_ACTIVE
            ])->get();

            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', __('message.plan_fetch_success'));
            $this->setData('plans', $plans);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }

    /**
     * @param DashboardDetailRequest $request
     * 
     * @return ApiResponse 
     */

    public function planDetails(DashboardDetailRequest $request)
    {
        try {

            $plans = $this->plan->with(['developmentAreas'])->where([
                'user_id' => $request->user->id,
                'uuid' => $request->plan_id,
                'status' => AppConstant::STATUS_ACTIVE
            ])->first();

            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', __('message.plan_fetch_success'));
            $this->setData('plans', $plans);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }
}
