<?php

namespace App\Models;

use App\Models\Reflection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    protected $table = 'activity';

    protected $primaryKey = 'id';

    protected $fillable = [
        'development_area_id', 'activity_type', 'activity', 'potential_date', 'actual_date', 'is_completed'
    ];

    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];

    public function reflections()
    {
        return $this->hasMany(Reflection::class, 'activity_id', 'id');
    }
}
