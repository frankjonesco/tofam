<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    // ADMIN: INDEX
    public function adminIndex(){
        return view('dashboard.industries.index', [
            'industries' => Site::allIndustries()
        ]);
    }

    // ADMIN: MINE
    public function mine(){
        return view('dashboard.industries.index', [
            'industries' => Site::myIndustries()
        ]);
    }

    // ADMIN: SHOW
    public function adminShow(Industry $industry){
        return view('dashboard.industries.show', [
            'industry' => $industry,
        ]);
    }

    // ADMIN: CREATE
    public function create(){
        return view('dashboard.industries.create');
    }

    // ADMIN: STORE
    public function store(Request $request, Industry $industry){
        
        $request->validate([
            'name' => 'required',
        ]);

        $industry = $industry->createIndustry($request);

        return redirect('dashboard/industries/'.$industry->hex.'/edit')->with('message', 'New industry created!');
    }

    // ADMIN: EDIT TEXT
    public function edit(Industry $industry){
        return view('dashboard.industries.edit', [
            'industry' => $industry
        ]);
    }

    // ADMIN: UPDATE TEXT
    public function update(Request $request, Industry $industry){
        
        // Validate form fields 
        $request->validate([
            'name' => 'required',
        ]);

        $industry = $industry->saveText($request);

        return redirect('dashboard/industries/'.$industry->hex.'/edit')->with('message', 'Industry text updated!');
    }

    // ADMIN: DELETE
    public function destroy(Industry $industry){
        $industry->delete();
        return redirect('dashboard/industries')->with('message', 'Industry deleted!');
    }
}
