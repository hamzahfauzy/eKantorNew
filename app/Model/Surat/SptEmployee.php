<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;
use App\Model\Surat\SptList;

class SptEmployee extends Model
{
    //
    protected $fillable = ['employee_id','spt_id'];
    public $timestamps = false;

    function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }

    function list()
    {
        return $this->hasOne(SptList::class,'id','spt_id');
    }
}
