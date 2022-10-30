<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ColorSwatch extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }

    // Relationship to colors
    public function colors(){
        return $this->hasMany(Color::class, 'color_swatch_id');
    }

    // Accessor for retrieving and formatting 'created_at'
    public function getUpdatedAtAttribute($value){
        return Carbon::parse($this->attributes['updated_at'])->format('d/m/Y');
    }

    public function inUse(){
        if($this->id == Config::where('id', 1)->first()->color_swatch_id){
            return true;
        }
        return false;
    }
}
