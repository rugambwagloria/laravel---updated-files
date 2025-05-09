<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\School;
class SchoolController extends Controller
{

    public function create()
    {
        return view('pages.school');
    }

    public function show()
    {

    }
    public function displaySchoolDetails(){
        $school_representative=School::all();

        if($school_representative->isEmpty()){

            dd('No schools found');

        }else{

        return view ('pages.school-management',compact('school_representative'));
    }
}
    public function store(Request $request)
    {
        try {
            // Validate input
            $validatedData = request()->validate([
                'school_name' => 'required|max:50',
                'school_regNo' => 'required|unique:school_representative|max:15',
                'school_district' => 'required|max:50',
                'school_phone' => 'required|max:15',
                'rep_name' => 'required|max:50',
                'rep_username' => 'required|unique:school_representative|max:50',
                'rep_email' => 'required|email|max:50',
                'rep_phone' => 'required|max:15',
                'rep_password' => 'required|max:60',


            ]);





        } catch (\Exception $e) {
            \Log::error('Validation error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while validating the data.');
        }
        try {
            $school = new School();

            $school->school_name = $validatedData['school_name'];
            $school->school_regNo = $validatedData['school_regNo'];
            $school->school_district = $validatedData['school_district'];
            $school->school_phone = $validatedData['school_phone'];
            $school->rep_name = $validatedData['rep_name'];
            $school->rep_username = $validatedData['rep_username'];
            $school->rep_email = $validatedData['rep_email'];
            $school->rep_phone = $validatedData['rep_phone'];
//                hsh the password with sha256 first
            $validatedData['rep_password'] = hash('sha256', $validatedData['rep_password']);
            $school->rep_password = $validatedData['rep_password'];

            $school->save();

            return back()->with('success', 'School created successfully!');
        } catch (\Exception $e) {
            \Log::error('Database error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while creating the school.');
        }


    }
}
