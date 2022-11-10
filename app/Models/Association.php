<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    // Relationship to article
    public function article(){
        return $this->belongsTo(Article::class, 'article_id');
    }

    // Relationship to company
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
}
