<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Employee extends Model
{
    use HasFactory;
    
    protected $table = "employees";

    protected $primaryKey = "id";

    protected $fillable = [
        'firstName',
        'lastName',
        'emailAddress',
        'telephone',
        'dateOfBirth',
        'streetAddress',
        'city',
        'postalCode',
        'country',
        'uniqueId',
    ];

    protected static function booted()
    {
        static::creating(function ($employee) {

            $length = 2;

            //Characters
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $charactersString = '';
            for ($i = 0; $i < $length; $i++) {
                $charactersString .= $characters[rand(0, $charactersLength - 1)];
            }
    
            //Numbers
            $number_string = rand(1000,9999);

            $employee->uniqueId = $charactersString.$number_string;
        });
    }

    // Skill connection
    public function skills()
    {
        return $this->hasMany(EmployeeSkills::class)->orderBy('skill', 'asc');;
    }


    //Validate the data being posted or updated
    public function validate($request) {

        //Validate employee general info
        $validator = Validator::make($request->all(), [
            'firstName'=>'required',
            'lastName'=>'required',
            'telephone'=>'required',
            'emailAddress'=>'sometimes|email',
            'dateOfBirth'=>'sometimes|date',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return array(
                "failed"=>true,
                "message"=>$messages[0]
            );
        }

        //Validate the skills
        $allowedseniorityRatings = array("Entry-level","Mid-level","Senior-level");
        if($request->input('skills')){
            foreach($request->input('skills') as $new_skill){
                $validator = Validator::make($new_skill, [
                    'skill'=>'required',
                    'yearsExperience'=>'required|integer',
                    'seniorityRating'=>'required|in:' . implode(',', $allowedseniorityRatings),
                ]);

                if ($validator->fails()) {
                    $messages = $validator->messages()->all();
                    return array(
                        "failed"=>true,
                        "message"=>"On skills: ".$messages[0]
                    );
                }
            }
        }
        
    }

}


