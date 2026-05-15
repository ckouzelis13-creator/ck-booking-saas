<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function shop()
    {
        return $this->belongsTo(Shop::class); // σύνδεση με το μαγαζί
    }

}
