<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reflection extends Model
{
    protected $table = 'reflections';

    protected $primaryKey = 'id';

    protected $fillable = [
        'activity_id', 'outcome_activity', 'description', 'reflaction_date'
    ];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];
}
