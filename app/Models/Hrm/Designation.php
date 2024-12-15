<?php

namespace App\Models\Hrm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use HasFactory,SoftDeletes;

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id')->withTrashed();
    }

    public function employee()
    {
        return $this->hasMany(Employee::class,'designation_id');
    }
}
