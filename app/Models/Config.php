<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    public function updateColorSwatch($color_swatch_id){
        Config::where('id', 1)->update(['color_swatch_id' => $color_swatch_id]);
    }
}
