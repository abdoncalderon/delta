<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    protected $fillable = ['user_id','project_id','role_id', 'isActive'];

    public function user()
    {
        return $this->belongsTo(User::class)->with('person');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function locationProjectUsers()
    {
        return $this->hasMany(LocationProjectUser::class);
    }

    public function needRequests()
    {
        return $this->hasMany(NeedRequest::class);
    }
}
