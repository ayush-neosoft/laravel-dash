<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubUser extends Model
{
    protected $table = 'sub_users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'parent_id', 'child_id'
    ];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];
}
