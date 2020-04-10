<?php

namespace App\Http\Controllers\Api\v1\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityCompletionRequest;
use App\Http\Requests\ActivityRequest;
use App\Http\Requests\AddPlanRequest;
use App\Http\Requests\DashboardDetailRequest;
use App\Http\Requests\DevelopmentAreaRequest;
use App\Http\Requests\ReflectionRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Activity;
use App\Models\DevelopmentArea;
use App\Models\Plan;
use App\Models\Reflection;
use App\Traits\ApiResponse;
use App\Utils\AppConstant;
use Exception;

class PlanController extends Controller
{
    use ApiResponse;

    protected $plan, $developmentArea, $activity, $reflection;

    public function __construct()
    {
        $this->plan = new Plan();
        $this->developmentArea = new DevelopmentArea();
        $this->activity = new Activity();
        $this->reflection = new Reflection();
    }

    /**
     * List of Plans @param Request $request
     * 
     *  @return ApiResponse
     */
    public function dashboardPlans(Request $request)
    {
        try {
            $user = $request->user;

            $plans = $this->plan->where([
                'user_id' => $user->id,
                'status' => AppConstant::STATUS_ACTIVE
            ])->orderBy('created_at', 'desc')->get();

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
            $this->setMeta('message', __('message.plan_detail_fetch'));
            $this->setData('plans', $plans);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }

    /**
     * @param AddPlanRequest $request
     * 
     * @return ApiResponse 
     */
    public function plan(AddPlanRequest $request)
    {
        try {

            $user = $request->user;

            if ($request->filled('plan_id')) {
                $plan = $this->plan->where('uuid', $request->plan_id)->first();
                $message = __('message.update_plan');
            } else {
                $plan = $this->plan;
                $plan->user_id = $user->id;
                $message = __('message.add_plan');
            }

            $plan->year = $request->year;
            $plan->position_title = $request->position_title;
            $plan->role_years = $request->role_years;
            $plan->responsibility = $request->responsibility;
            $plan->competence_area = $request->competence_area;
            $plan->where_in_next_year = $request->where_in_next_year;
            $plan->where_after_next_year = $request->where_after_next_year;
            $plan->save();

            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', $message);
            $this->setData('plan', $plan);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }

    /**
     * @param DevelopmentAreaRequest $request
     * 
     * @return ApiResponse 
     */
    public function developmentArea(DevelopmentAreaRequest $request)
    {
        try {

            if ($request->filled('development_id')) {
                $developmentArea = $this->developmentArea->find($request->development_id);
                $message = __('message.update_development_area');
            } else {
                $developmentArea = $this->developmentArea;
                $developmentArea->plan_id = $request->plan_id;
                $message = __('message.add_development_area');
            }
            $developmentArea->plan_area = $request->plan_area;
            $developmentArea->description = $request->description;
            $developmentArea->save();

            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', $message);
            $this->setData('development_area', $developmentArea);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }

    /**
     * @param ActivityRequest $request
     * 
     * @return ApiResponse 
     */
    public function activity(ActivityRequest $request)
    {
        try {

            if ($request->filled('activity_id')) {
                $activity = $this->activity->find($request->activity_id);
                $message = __('message.update_activity');
            } else {
                $activity = $this->activity;
                $activity->development_area_id = $request->development_area_id;
                $message = __('message.add_activity');
            }
            $activity->activity_type = $request->activity_type;
            $activity->activity = $request->activity;
            $activity->potential_date = $request->potential_date;
            $activity->actual_date = $request->actual_date;
            $activity->is_completed = $request->is_completed;
            $activity->save();

            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', $message);
            $this->setData('activity', $activity);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }

    /**
     * @param ReflectionRequest $request
     * 
     * @return ApiResponse 
     */
    public function reflection(ReflectionRequest $request)
    {
        try {

            if ($request->filled('reflection_id')) {
                $reflection = $this->reflection->find($request->reflection_id);
                $message = __('message.update_reflection');
            } else {
                $reflection = $this->reflection;
                $reflection->activity_id = $request->activity_id;
                $message = __('message.add_reflection');
            }
            $reflection->outcome_activity = $request->outcome_activity;
            $reflection->description = $request->description;
            $reflection->reflection_date = $request->reflection_date;
            $reflection->save();

            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', $message);
            $this->setData('reflection', $reflection);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }

    /**
     * @param ActivityCompletionRequest $request
     * 
     * @return ApiResponse 
     */
    public function completeActivity(ActivityCompletionRequest $request)
    {
        try {

            $activity = $this->activity->find($request->activity_id);
            $activity->is_completed = $request->status;
            $activity->save();

            $message = $request->is_completed ? __('message.activity_complete') : __('message.activity_incomplete');

            $this->setMeta('status', AppConstant::STATUS_OK);
            $this->setMeta('message', $message);
            $this->setData('reflection', $activity);
            return response()->json($this->setResponse(), AppConstant::OK);
        } catch (Exception $e) {
            $this->setMeta('status', AppConstant::STATUS_FAIL);
            $this->setMeta('message',  __('auth.server_error'));
            return response()->json($this->setResponse(), AppConstant::UNPROCESSABLE_REQUEST);
        }
    }
}
