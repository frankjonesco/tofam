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
    
    public function register(){
        return view('users.register');
    }

    public function storestoreSignup(Request $request){
        
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

    // Admin: Show form for create user
    public function create(){
        return view('dashboard.users.create');
    }

    // Admin: Store new user
    public function store(Request $request){
        
        $formFields = $request->validate([
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'gender' => 'required',
            'username' => ['required', Rule::unique('users', 'username')],
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);

        // Generare a random hex that does not already exist
        $hex = Str::random('11');
        while(User::where('hex', $hex)->exists()){
            $hex = Str::random('11');
        }
        $formFields['hex'] = $hex;

        // Set non input dependent fields
        $formFields['user_type_id'] = 1;
        $formFields['email_verified_at'] = now();
        $formFields['remember_token'] = Str::random(10);

        // Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create user
        $user = User::create($formFields);

        return redirect('/dashboard')->with('message', 'User created!');

    }

    // Admin: Show form for edit user
    public function edit(User $user){
        return view('dashboard.users.edit', [
            'user' => $user
        ]);
    }

    // Admin: Update user
    public function update(User $user, Request $request){
        $formFields = $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'gender' => 'required',
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update($formFields);

        return redirect('/users')->with('message', 'User updated!');

    }

    // Admin: Show form for edit password
    public function editPassword(User $user){
        return view('dashboard.users.edit-password', [
            'user' => $user
        ]);
    }

    // Admin: Delete user
    public function destroy(User $user){

        // Make sure the logged in user is the owner
        if($user->id == auth()->id()){
            // abort(403, 'Unathorised Action.');
            return back()->with('staticError', 'You cannot delete your own account. Contact support.');
        }

        $user->delete();

        return redirect('users')->with('message', 'User deleted!');
    }
    

}
