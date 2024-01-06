<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = ['uid','stakeholder_person_id','state','record','date','time','type','clock_id'];

    public function stakeholderPerson()
    {
        return $this->belongsTo(StakeholderPerson::class);
    }
    
    public function clock()
    {
        return $this->belongsTo(Clock::class);
    }
}
