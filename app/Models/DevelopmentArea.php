<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DevelopmentArea extends Model
{
    protected $table = 'development_area';

    protected $primaryKey = 'id';

    protected $fillable = [
        'plan_id', 'plan_area', 'description'
    ];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'development_area_id', 'id')
            ->with('reflactions');
    }
}
