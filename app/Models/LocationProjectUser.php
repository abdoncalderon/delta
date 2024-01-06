<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationProjectUser extends Model
{
    protected $fillable = ['location_id','project_user_id','profile','receive_notification',];

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function projectUser(){
        return $this->belongsTo(ProjectUser::class);
    }
}
