<?php

namespace App\Models;

use App\Models\Reflection;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];

    public function reflections()
    {
        return $this->hasMany(Reflection::class, 'activity_id', 'id');
    }
}
