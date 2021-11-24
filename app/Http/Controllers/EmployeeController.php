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
    public function index(Request $request)
    {
        $searchKeyword=$request->input('search');
        $yearOfBirth=$request->input('yearOfBirth');
        $skill=$request->input('skill');

        $results = Employee::query()->with('skills')->orderBy('firstName', 'asc');

        if (!empty($searchKeyword)){
            $results = $results->where('firstName', 'like', '%'.$searchKeyword.'%')
            ->orWhere('lastName', 'LIKE', '%'.$searchKeyword.'%')
            ->orWhere('emailAddress', 'LIKE', '%'.$searchKeyword.'%');
        }

        if (!empty($skill)){
            $results = $results->whereHas('skills', function ($query) use ($skill) {
                $query->where('skill', 'like', '%'.$skill.'%');
            });
        }

        if (!empty($yearOfBirth)){
            $results->whereYear('dateOfBirth', $yearOfBirth);
        }

        return  $results->paginate(100);
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
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {   
        $employee->load('skills');
        return $employee;
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
        //Validate
        $employeeModel = new Employee();
        $validated = $employeeModel->validate($request);
        if($validated['failed']){
            return response()->json(array("error"=>$validated['message']), 400);
        }

        //Find the record and update it
        $employee = Employee::find($id);
        $employee->update($request->all());

        //Update the skills
        if($request->has('skills')){
            //Delete all current skills assigned to employee
            $employee->skills()->delete();

            //Update the employee with new skills
            foreach($request->input('skills') as $new_skill){
                $skill = new EmployeeSkills();
                $skill->skill = $new_skill['skill'];
                $skill->yearsExperience = array_key_exists('yearsExperience', $new_skill)?$new_skill['yearsExperience']:"0";
                $skill->seniorityRating = array_key_exists('seniorityRating', $new_skill)?$new_skill['seniorityRating']:"";
                $employee->skills()->save($skill);
            }
        }

        //get the updated record icluding the skills
        $employee->load('skills');

        return $employee;
    }

    /**
     * Remove the specified employee.
     *
     * @param  Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        return  $employee->delete();
    }
}
