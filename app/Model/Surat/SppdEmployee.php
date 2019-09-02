<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;
use App\Model\Surat\SppdList;

class SppdEmployee extends Model
{
    //
    protected $fillable = ['employee_id','sppd_id','no_urut','uang_harian','representatif','transport','penginapan'];
    public $timestamps = false;

    function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }

    function getTotalBiayaAttribute()
    {
        return $this->uang_harian > 0 && $this->uang_harian != "" ? $this->uang_harian + $this->representatif + $this->transport + $this->penginapan : 0;
    }

    function list()
    {
        return $this->hasOne(SppdList::class,'id','sppd_id');
    }
}
