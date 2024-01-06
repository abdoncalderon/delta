<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakeholderPersonShift extends Model
{
    protected $fillable = ['stakeholder_person_id','shift_id','date'];

    public function stakeholderPerson(){
        return $this->belongsTo(StakeholderPerson::class);
    }

    public function shift(){
        return $this->belongsTo(Shift::class);
    }
}
