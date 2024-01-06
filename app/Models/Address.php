<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['person_id', 'city_id', 'address', 'postalCode'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
