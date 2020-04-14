<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $hidden = [
        'id', 'status', 'created_at', 'updated_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
