<?php

namespace App\Models\Salary;

use App\Models\Hrm\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuttingSalary extends Model
{
    use HasFactory, SoftDeletes;

    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id')->withTrashed();
    }
}
