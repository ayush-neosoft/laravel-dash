<?php

namespace App\Models;

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

    public function reflactions(): HasMany
    {
        return $this->hasMany(Reflaction::class, 'activity_id', 'id');
    }
}
