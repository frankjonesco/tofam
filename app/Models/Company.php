<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }

    // Accessor for retrieving and formatting 'short_body'
    public function getAddressAttribute($value){
        if($this->address_number && $this->address_street && $this->address_city && $this->address_zip){
            return $this->address_street.' '.$this->address_number.', '.$this->address_zip.' '.$this->address_city;
        }
        elseif($this->address_street && $this->address_city && $this->address_zip){
            return $this->address_street.', '.$this->address_zip.' '.$this->address_city;
        }
        return null;
    }
}
