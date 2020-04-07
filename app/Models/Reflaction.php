<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reflaction extends Model
{
    protected $table = 'reflaction';

    protected $primaryKey = 'id';

    protected $fillable = [
        'activity_id', 'outcome_activity', 'description', 'reflaction_date'
    ];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];
}
