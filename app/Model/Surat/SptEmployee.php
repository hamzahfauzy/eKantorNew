<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;

class SptEmployee extends Model
{
    //
    protected $fillable = ['employee_id','spt_id'];

    function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }
}
