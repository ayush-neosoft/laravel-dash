<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UserPaymentDetail extends Model
{
    protected $table = 'user_payment_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid', 'user_id'
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
}
