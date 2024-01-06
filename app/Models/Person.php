<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['uid', 'fullName', 'firstName', 'lastName', 'gender_id', 'birthDate', 'jobTitle', 'email', 'city_id', 'address', 'homePhone', 'mobilePhone', 'photo', 'signature', 'isActive', 'blocked', ];

       
    public function city(){
        return $this->belongsTo(City::class);
    }

    public function stakeholderPeople(){
        return $this->hasMany(StakeholderPerson::class);
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function phones(){
        return $this->hasMany(Phone::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function isActive(){
        if($this->isActive==1){
            return true;
        }else{
            return false;
        }
    }
}
