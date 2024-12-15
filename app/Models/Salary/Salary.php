<?php

namespace App\Models\Salary;

use App\Models\Admin\Store;
use App\Models\Hrm\Designation;
use App\Models\Hrm\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id')->withTrashed();
    }
}
