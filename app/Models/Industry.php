<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }
    
    // Relationship to companies
    public function companies(){
        return $this->hasMany(Company::class, 'industry_ids');
    }

    // Find unique hex for industries
    public function uniqueHex($site, string $field = 'hex', int $length = 11){
        return $site->uniqueHex('industries');
    }
}
