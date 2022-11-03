<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Show all companies
    public function index(){
        return view('companies.index', [
            'companies' => Company::orderBy('registered_name', 'ASC')->paginate(12)
        ]);
    }

    // Show single company
    public function show(Company $company, $hex = null){
        return view('companies.show', [
            'company' => $company
        ]);
    }
}
