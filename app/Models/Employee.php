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

    // Skill connection
    public function skills()
    {
        return $this->hasMany(EmployeeSkills::class)->orderBy('skill', 'asc');;
    }

}


