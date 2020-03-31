<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Development extends Model
{
    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }
}
