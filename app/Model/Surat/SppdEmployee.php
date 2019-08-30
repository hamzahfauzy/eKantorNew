<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;
use App\Model\Surat\SppdList;

class SppdEmployee extends Model
{
    //
    protected $fillable = ['employee_id','sppd_id','no_urut'];
    public $timestamps = false;

    function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }

    function list()
    {
        return $this->hasOne(SppdList::class,'id','sppd_id');
    }
}
