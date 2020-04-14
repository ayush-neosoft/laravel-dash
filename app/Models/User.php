<?php

namespace App\Models;

use App\Models\Plan;
use Ramsey\Uuid\Uuid;
use App\Models\UserMeta;

use App\Models\UserDetail;
use App\Notifications\VerifyApiEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $guarded = [];
    protected $hidden = ['password', 'created_at', 'updated_at'];

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

    public function details()
    {
        return $this->hasMany(UserDetail::class);
    }

    public function usermeta()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function verify()
    {
        $this->email_verified_at = date("Y-m-d g:i:s");
        return $this->update();
    }

    public function send_api_email_verify_notification()
    {
        $this->notify(new VerifyApiEmail); // my notification
    }
}
