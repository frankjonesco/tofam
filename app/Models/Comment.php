<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    // MODEL RELATIONSHIPS

    // Relationship to company
    public function company(){
        return $this->belongsTo(Company::class, 'resource_id');
    }

    // Relationship to user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


    // ACCESSORS

    // Accessor for retrieving and formatting 'created_at'
    public function getDateAttribute($value){
        return Carbon::parse($this->attributes['created_at'])->format('d M Y - H:i');
    }
}
