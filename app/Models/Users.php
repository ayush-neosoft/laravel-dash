<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Uuid;

class Users extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid', 'first_name', 'last_name', 'email', 'mobile_no', 'saica_number', 'irba_number', 'role', 'forgot_password_code', 'is_verified'
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

    /**
     * Get User Details
     * 
     * @return array
     */
    public function userDetails(): HasMany
    {
        return $this->hasMany(UserDetails::class, 'user_id', 'id');
    }

    /**
     * Get Sub Users
     * 
     * @return array
     */
    public function subUsers(): HasMany
    {
        return $this->hasMany(SubUsers::class, 'parent_id', 'id');
    }

    /**
     * Get All Plans
     * 
     * @return array
     */
    public function plans(): HasMany
    {
        return $this->hasMany(Plans::class, 'user_id', 'id');
    }
}
