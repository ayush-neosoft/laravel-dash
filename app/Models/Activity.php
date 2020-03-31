<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function reflection()
    {
        return $this->hasOne('App\Models\Reflection');
    }

    public function development()
    {
        return $this->belongsTo('App\Models\Development');
    }
}
