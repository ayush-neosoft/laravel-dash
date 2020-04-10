<?php

use App\Models\Activity;
use App\Models\DevelopmentArea;
use App\Models\Plan;
use App\Models\Reflection;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    public function run()
    {
    	$plans = array(
    	    array(
    	        'user_id' => 1,
    	        'year' => '2017',
    	        'position_title' => 'Lorem Ipsum 2017.',
    	        'role_years' => '7',
    	        'responsibility' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	        'competence_area' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	        'where_in_next_year' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	        'where_after_next_year' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	    ),
    	    array(
    	        'user_id' => 1,
    	        'year' => '2018',
    	        'position_title' => 'Lorem Ipsum 2018.',
    	        'role_years' => '8',
    	        'responsibility' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	        'competence_area' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	        'where_in_next_year' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	        'where_after_next_year' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	    ),
    	    array(
    	        'user_id' => 1,
    	        'year' => '2019',
    	        'position_title' => 'Lorem Ipsum 2019.',
    	        'role_years' => '9',
    	        'responsibility' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	        'competence_area' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	        'where_in_next_year' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	        'where_after_next_year' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	    )
    	);

    	$developments = array(
    	    'plan_area' => 'Development Area.',
    	    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	);

    	$activities = array(
    	    'activity_type' => 'Activity',
    	    'activity' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	    'potential_date' => Carbon::now()->format('Y-m-d'),
    	    'actual_date' => Carbon::now()->format('Y-m-d')
    	);

    	$reflections = array(
    	    'outcome_activity' => 'Reflaction',
    	    'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    	    'reflection_date' => Carbon::now()->format('Y-m-d')
    	);

    	for ($i = 0; $i < count($plans); $i++) {
    	    $plan = new Plan();
    	    $plan->user_id = $plans[$i]['user_id'];
    	    $plan->year = $plans[$i]['year'];
    	    $plan->position_title = $plans[$i]['position_title'];
    	    $plan->role_years = $plans[$i]['role_years'];
    	    $plan->responsibility = $plans[$i]['responsibility'];
    	    $plan->competence_area = $plans[$i]['competence_area'];
    	    $plan->where_in_next_year = $plans[$i]['where_in_next_year'];
    	    $plan->where_after_next_year = $plans[$i]['where_after_next_year'];
    	    $plan->save();

    	    for ($k = 0; $k < 3; $k++) {
    	        $development = new DevelopmentArea();
    	        $development->plan_id = $plan->id;
    	        $development->plan_area = $developments['plan_area'] . " " . $plans[$i]['year'] . "-" . $i;
    	        $development->description = $developments['description'];
    	        $development->save();

    	        for ($k = 0; $k < 2; $k++) {
    	            $activity = new Activity();
    	            $activity->development_area_id = $development->id;
    	            $activity->activity_type = $activities['activity_type'] . " " . $plans[$i]['year'] . "-" . $k;
    	            $activity->activity = $activities['activity'];
    	            $activity->potential_date = $activities['potential_date'];
    	            $activity->actual_date = $activities['actual_date'];
    	            $activity->save();

    	            $reflection = new Reflection();
    	            $reflection->activity_id = $activity->id;
    	            $reflection->outcome_activity = $reflections['outcome_activity'] . " " . $plans[$i]['year'] . "-" . $k;
    	            $reflection->description = $reflections['description'];
    	            $reflection->reflection_date = $reflections['reflection_date'];
    	            $reflection->save();
    	        }
    	    }
    	}
    }
}
