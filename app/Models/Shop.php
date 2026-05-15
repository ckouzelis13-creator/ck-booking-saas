<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model; // Χρειαζόμαστε αυτό το import

#[Fillable(['name', 'slug', 'phone', 'user_id', 'primary_color', 'accent_color', 'logo_path'])] // Εδώ επιτρέπουμε τα πεδία
class Shop extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function employees() // σύνδεση με τους υπαλλήλους πολλους καθε μαγαζι
    {
        return $this->hasMany(Employee::class);
    }
}
