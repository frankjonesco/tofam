<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home(){
        return view('home');
    }

    public function showTerms(){
        return view('terms');
    }

    public function showPrivacy(){
        return view('privacy');
    }

    public function showAbout(){
        return view('about');
    }

    public function showContact(){
        return view('contact');
    }
}
