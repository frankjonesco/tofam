<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
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

    /**
    * User Relationships
    */

    // Relationship to articles
    public function articles(){
        return $this->hasMany(Article::class, 'user_id');
    }

    // Relationship to user type
    public function user_type(){
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    // Relationship to country
    public function country(){
        return $this->belongsTo(Country::class, 'country_iso', 'iso');
    }

    // Relationship to country
    // public function color(){
    //     return $this->belongsTo(Color::class, 'color_id', 'fill_id');
    // }



    // Accessors

    // Accessor for user.full_name
    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    // Accessor for user.article_count
    public function getArticleCountAttribute(){
        return Article::where('user_id', $this->id)->count();
    }

    public function getColorAttribute(){
       
        $color_swatch_id = Config::where('id', 1)->first()->color_swatch_id;
        
        $color = Color::where([
                'color_swatch_id' => $color_swatch_id,
                'fill_id' => $this->color_fill_id
            ])->first();
            
        return $color;
    }









    // Find unique hex for users
    public function uniqueHex($site, string $field = 'hex', int $length = 11){
        return $site->uniqueHex('users');
    }


    // Log user in
    public function logUserIn($user){
        auth()->login($user);
    }

    public function logUserInRegenerateSession($request, $formFields){
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
        }
    }

    // Log user out
    public function logUserOut($request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    // Compile category data
    public function compileUserData($request, $user){
        $site = new Site();
        $user->hex = ($user->hex) ? $user->hex : self::uniqueHex($site);
        $user->user_type_id = $request->user_type_id ?? 1;
        $user->first_name = ucfirst($request->first_name);
        $user->last_name = ucfirst($request->last_name);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->password);
        $user->remember_token = Str::random(10);
        $user->gender = $request->gender;
        $user->country_iso = $request->country_iso ?? null;
        $user->color_id = $site->randomColorId();
        $user->blocked = null;

        $user->image = $user->image;
        if($request->hasFile('image')){
            $user->image = $site->handleImageUpload($request, 'users', $user->hex);
        }
        
        return $user;
    }

    // Create category (insert)
    public function createUser($request, $user){
        $user = self::compileUserData($request, $user);
        $user->save();
    }

    public function createUserAndLogIn($request, $user){
        self::createUser($request, $user);
        self::logUserIn($user);
    }

    // Save User (update)
    public function saveUser($request, $user){
        $user = self::compileUserData($request, $user);
        $user->save();
    }

    public function oldPasswordIncorrect($request, $user){
        return Hash::check($request->old_password, $user->password);
    }

    public function savePassword($request, $user){
        $user->password = bcrypt($request->new_password);
        $user->save();
    }

    public function isLoggedInUser($user){
        if($user->id == auth()->id()){
            return true;
        }
        return false;
    }


}
