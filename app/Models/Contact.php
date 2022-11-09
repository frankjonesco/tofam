<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    // Set route key name
    public function getRouteKeyName(){
        return 'hex';
    }


    // MODEL RELATIONSHIPS

    // Relationship to company
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }


    // ACCESSORS

    // Accessor for retrieving and formatting 'formal_name'
    public function getFormalNameAttribute($value){
        $formal_name = $this->salutation.' '.$this->first_name.' '.$this->last_name;
        $formal_name = trim($formal_name);
        return $formal_name;
    }



    // DATA HANDLING CALL METHODS

    // Create contact (insert)
    public function createContact($request, $company){
        $site = new Site();
        $contact = Contact::create([
            'hex' => $site->uniqueHex('contacts'),
            'user_id' => auth()->user()->id,
            'company_id' => $company->id,
            'salutation' => $request->salutation,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'job_title' => $request->job_title,
            'department' => $request->department,
            'email' => $request->email,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'active' => 1
        ]);
        return $contact;
    }

    // Save contact (update)
    public function saveContact($request, $contact){
        $contact->salutation = $request->salutation;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->gender = $request->gender;
        $contact->job_title = $request->job_title;
        $contact->department = $request->department;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->mobile = $request->mobile;
        $contact->save();
        return $contact;
    }



    // DATA HANDLERS

    // Compile company data
    public function compileCreationData($request){
        
    }



}
