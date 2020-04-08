<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Plan extends Model
{
    protected $table = 'plans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid', 'user_id', 'year', 'position_title', 'role_years', 'responsibility', 'competence_area', 'where_in_next_year', 'where_after_next_year'
    ];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->uuid = Uuid::uuid4();
        });
    }

    public function developmentAreas(): HasMany
    {
        return $this->hasMany(DevelopmentArea::class, 'plan_id', 'id')->with('activities');
    }
}
