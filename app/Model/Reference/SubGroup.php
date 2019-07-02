<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;

class SubGroup extends Model
{
    //
    protected $fillable = ['nama','kepala_id','group_id'];

    function kepala()
    {
    	return $this->hasOne(Employee::class,'id','kepala_id');
    }

    function subGroupStaffs()
    {
    	return $this->hasMany(SubGroupStaff::class,'sub_group_id','id');
    }

    function group()
    {
    	return $this->hasOne(Group::class,'id','group_id');
    }
}
