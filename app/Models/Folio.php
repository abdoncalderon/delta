<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    protected $fillable = ['date','location_id','project_user_id','number',];

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function daily_reports(){
        return $this->hasMany(DailyReport::class);
    }

    public function notes(){
        return $this->hasMany(Note::class);
    }

    public function status(){

       /*  if(is_valid_date_for_open_folio($this->date,$this->location)){
            return __('content.opened');
        }else{
            return __('content.closed');
        } */

        /* $today = strtotime(Carbon::today()->toDateString());
        $differenceInHours = abs(round(($date - $today)/60/60,0));
        
        // $locationMaxTimeOpenFolio = $this->location->max_time_open_folio;
        $location = Location::find($this->location_id);
        $locationMaxTimeOpenFolio = $location->max_time_open_folio;
        if (($differenceInHours > $locationMaxTimeOpenFolio)){
            return __('content.closed');
        }else{
            return __('content.opened');
        } */
        
    }
}
