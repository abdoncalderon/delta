<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    protected $fillable = ['name','start','finish','nextday','project_id'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
