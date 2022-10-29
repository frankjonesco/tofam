<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    // Relationship to user
    public function users(){
        return $this->hasMany(User::class, 'color_id');
    }

    // Relationship to color swatch
    public function color_swatch(){
        return $this->belongsTo(ColorSwatch::class, 'color_swatch_id');
    }
}
