<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    // Get all categories
    public function getAllCategories(){
        return Category::orderBy('name', 'asc')->get();
    }

    // Find unique hex for 'table'
    public function uniqueHex(string $table, string $field = 'hex', int $length = 11){
        $hex = Str::random($length);
        while(DB::table($table)->where($field, $hex)->exists()){
            $hex = Str::random($length);
        }
        return $hex;
    }
}
