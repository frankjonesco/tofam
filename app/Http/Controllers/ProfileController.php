<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Show logged in user's profile
    public function show(){
        return view('profile.show', [
            'user' => auth()->user()
        ]);
    }
}
