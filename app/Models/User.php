<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\SubUser;
use App\Models\UserDetail;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid', 'first_name', 'last_name', 'email', 'contact_no', 'mobile_no', 'saica_number', 'irba_number', 'role', 'forgot_password_code', 'is_verified'
    ];
    protected $hidden = [
        'id', 'password', 'status', 'created_at', 'updated_at'
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

    /**
     * Get User Details
     * 
     * @return array
     */
    public function userDetails()
    {
        return $this->hasMany(UserDetail::class, 'user_id', 'id');
    }

    /**
     * Get Sub Users
     * 
     * @return array
     */
    public function subUsers()
    {
        return $this->hasMany(SubUser::class, 'parent_id', 'id');
    }

    /**
     * Get All Plans
     * 
     * @return array
     */
    public function plans()
    {
        return $this->hasMany(Plan::class, 'user_id', 'id');
    }
}