<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
  
/**
 * Helper functions for global use
 *
 * @return response()
 */

if(!function_exists('shout')) {
    function shout(string $string){
        return Str::upper($string);
    }
}

// Generate a unique hex for 'table'
if(!function_exists('uniqueHex')){
    function uniqueHex(string $table, string $field = 'hex', int $length = 11){
        $hex = Str::random($length);
        while(DB::table($table)->where($field, $hex)->exists()){
            $hex = Str::random($length);
        }
        return $hex;
    }
}
