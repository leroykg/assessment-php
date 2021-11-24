<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSkills extends Model
{
    use HasFactory;

    protected $table = "skills";

    protected $primaryKey = "id";
    
    public function skills()
    {
        return $this->belongsTo(Employee::class);
    }
}
