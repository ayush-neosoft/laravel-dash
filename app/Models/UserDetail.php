<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $guarded = [];
    protected $hidden = ['id', 'status', 'created_at', 'updated_at'];
}
