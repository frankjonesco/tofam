<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{   
    private $site;
    private $category;
    private $article;

    public function __construct(Site $site, Category $category, Article $article)
    {
        $this->site = $site;
        $this->category = $category;
        $this->article = $article;
    }


    // SHOW ALL USERS
    public function index(){
        return view('users.index', [
            'users' => Site::activeUsers()
        ]);
    }
    

    // SHOW REGISTRATION FORM
    public function register(){
        return view('users.register');
    }


    // STORE REGISTRATION
    public function storeRegistration(Request $request, User $user){
        // Validate form fields
        $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Create user and log in
        $user->createUserAndLogIn($request, $user);

        return redirect('/')->with('message', 'Account created and user logged in!');
    }
    

    // LOG USER OUT
    public function logout(Request $request, User $user){
        $user->logUserOut($request);
        return redirect('/')->with('message', 'You have logged out!');
    }


    // SHOW LOGIN FORM
    public function login(){
        return view('users.login');
    }


    // AUTHENTICATE USER (FOR LOGIN)
    public function authenticateLogin(Request $request, User $user){
        // Validate form fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required' 
        ]);

        // Attempt to log user in and regenerate session
        if($user->logUserInRegenerateSession($request, ['email' => $request->email, 'password' => $request->password])){
            // Redirect to the dashboard
            return redirect('dashboard')->with('message', 'You have logged in!');
        }

        // Or fail and return error
        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }


    // ADMIN: SHOW FOR FOR CREATE USER
    public function create(Site $site){
        return view('dashboard.users.create', [
            'user_types' => $site->getUserTypes(),
            'countries' => $site->getCountries()
        ]);
    }


    // ADMIN: STORE NEW USER
    public function store(Request $request, User $user){
        // Validate form fields
        $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'gender' => 'required',
            'username' => ['required', 'min:3', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Create user
        $user->createUser($request, $user);

        return redirect('/dashboard')->with('message', 'User created!');
    }


    // ADMIN: SHOW FORM FOR EDIT USER
    public function edit(User $user, Site $site){
        return view('dashboard.users.edit', [
            'user' => $user,
            'user_types' => $site->getUserTypes(),
            'countries' => $site->getCountries()
        ]);
    }


    // ADMIN: UPDATE USER
    public function update(Request $request, User $user){
        $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'gender' => 'required',
            'user_type_id' => 'required',
            'username' => ['required', 'min:3', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        // Save changes to this user
        $user->saveUser($request, $user);

        return redirect('/users')->with('message', 'User updated!');
    }


    // ADMIN: SHOW FORM FOR EDIT PASSWORD
    public function editPassword(User $user){
        return view('dashboard.users.edit-password', [
            'user' => $user
        ]);
    }


    // ADMIN UPDATE PASSWORD
    public function updatePassword(Request $request, User $user){
        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if($user->oldPasswordIncorrect($request, $user)){
            return back()->with('staticError', 'Your old password is not correct. Try again.');
        }

        $user->savePassword($request, $user);

        return redirect('/users')->with('message', 'User password updated!');
    }


    // ADMIN: DELETE USER
    public function destroy(User $user){
        // Return error if a user attempts to delete their own account
        if($user->isLoggedInUser($user)){
            return back()->with('staticError', 'You cannot delete your own account. Contact support.');
        }
        
        // Or delete user
        $user->delete();

        return redirect('users')->with('message', 'User deleted!');
    }
    

}
