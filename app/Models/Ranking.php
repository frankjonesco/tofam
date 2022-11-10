<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }

    
    // MODEL RELATIONSHIPS

    // Relationship to company
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
}
