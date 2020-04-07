<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLicense extends Model
{
    protected $table = 'user_license';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'number_of_license', 'license_duration', 'duration', 'total'
    ];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];
}
