<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show all users
    public function index(){
        return view('users.index', [
            'users' => User::all()
        ]);
    }
    
    public function create(){
        return view('users.register');
    }

    public function store(Request $request){
        
        $formFields = $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Generare a random hex that does not already exist
        $hex = Str::random('11');
        while(User::where('hex', $hex)->exists()){
            $hex = Str::random('11');
        }

        $formFields['hex'] = $hex;

        // Set the user type id
        $formFields['user_type_id'] = 1;

        // Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create user
        $user = User::create($formFields);

        // Log in
        auth()->login($user);

        return redirect('/')->with('message', 'Account created and user logged in!');
    }

    // Log user out
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have logged out!');
    }

    // Show login form
    public function login(){
        return view('users.login');
    }

    // Authenticate user
    public function authenticate(Request $request){
        
        $formFields = $request->validate([
            'email' => 'required|email',
            'password' => 'required' 
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('dashboard')->with('message', 'You have logged in!');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');


    }

    

}
