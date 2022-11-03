<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Sponsor;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

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
