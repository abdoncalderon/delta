<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clock extends Model
{
    protected $fillable = ['name', 'ipAddress', 'port', 'project_id'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
