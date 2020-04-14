<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
