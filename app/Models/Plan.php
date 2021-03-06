<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Plan extends Model
{
    protected $table = 'plans';
    protected $primaryKey = 'id';
    protected $guarded = [];
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

    public function development_areas()
    {
        return $this->hasMany(DevelopmentArea::class, 'plan_id', 'id')->with('activities');
    }
}
