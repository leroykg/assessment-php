<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeSkills;

class EmployeeController extends Controller
{
    /**
     * Show all employees
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Create a new employee
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Validate
        $employeeModel = new Employee();
        $validated = $employeeModel->validate($request);
        if($validated['failed']){
            return response()->json(array("error"=>$validated['message']), 400);
        }
        
        //create the employee
        $employee = Employee::create([
            'uniqueId'=>"",
            'firstName'=>$request->input('firstName'),
            'lastName'=>$request->input('lastName'),
            'emailAddress'=>$request->input('emailAddress'),
            'telephone'=>$request->input('telephone'),
            'dateOfBirth'=>$request->input('dateOfBirth'),
            'streetAddress'=>$request->input('streetAddress'),
            'city'=>$request->input('city'),
            'postalCode'=>$request->input('postalCode'),
            'country'=>$request->input('country'),
        ]);
        
        //Add the skills
        if(count($request->input('skills'))){
            foreach($request->input('skills') as $new_skill){
                $skill = new EmployeeSkills();
                $skill->skill = $new_skill['skill'];
                $skill->yearsExperience = array_key_exists('yearsExperience', $new_skill)?$new_skill['yearsExperience']:"0";
                $skill->seniorityRating = array_key_exists('seniorityRating', $new_skill)?$new_skill['seniorityRating']:"";
                $employee->skills()->save($skill);
            }
        }

        //get the new record icluding the skills
        $employee->load('skills');

        return response()->json($employee, 201);
    }

    /**
     * Display a specified employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Edit an employee
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
