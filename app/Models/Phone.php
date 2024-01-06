<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['person_id','type_id','country_id','number'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
