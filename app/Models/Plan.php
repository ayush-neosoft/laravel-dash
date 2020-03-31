<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public function developments()
    {
        return $this->hasMany('App\Models\Activity');
    }
}
