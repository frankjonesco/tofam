<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Set route key name
    public function getRouteKeyName()
    {
        return 'hex';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationship to articles
    public function articles(){
        return $this->hasMany(Article::class, 'user_id');
    }


    // Accessors

    // Accessor for user.full_name
    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    // Accessor for user.article_count
    public function getArticleCountAttribute(){
        return Article::where('user_id', $this->id)->count();
    }

}
