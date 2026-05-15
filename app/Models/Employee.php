<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'email', 'shop_id'])]
class Employee extends Model
{
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}