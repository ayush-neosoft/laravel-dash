<?php

namespace App\Models;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class DevelopmentArea extends Model
{
    protected $table = 'development_areas';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class, 'development_area_id', 'id')->with('reflections');
    }
}
