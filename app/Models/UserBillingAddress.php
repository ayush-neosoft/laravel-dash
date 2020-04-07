<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBillingAddress extends Model
{
    protected $table = 'user_billing_address';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'bill_to', 'address_line_1', 'address_line_2', 'region', 'post_code', 'vat_number'
    ];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];
}
