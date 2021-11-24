<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}


