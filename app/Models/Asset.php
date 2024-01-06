<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['asset_category_id','serialNumber','inventoryCode','stock_movement_id','status_id',];

    public function assetCategory(){
        return $this->belongsTo(AssetCategory::class);
    }

    public function stockMovement(){
        return $this->belongsTo(Asset::class);
    }
    
    
}
