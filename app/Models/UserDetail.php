<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'device_name', 'os', 'ip_address'
    ];

    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];
}
