<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Show all companies
    public function index(){
        return view('companies.index', [
            'companies' => Company::where('active', 1)->orderBy('name', 'ASC')->get()
        ]);
    }
}
