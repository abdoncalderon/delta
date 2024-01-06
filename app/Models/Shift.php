<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['name','start','finish','nextday','breaktime','earlyCheckin','lateCheckout','overtime','project_id'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
       
}
