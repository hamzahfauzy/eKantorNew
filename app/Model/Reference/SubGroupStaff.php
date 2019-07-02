<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;

class SubGroupStaff extends Model
{
    //
    protected $table = 'sub_group_staffs';
    public $timestamps = false;
    protected $fillable = ['pegawai_id','sub_group_id'];

    function employee()
    {
    	return $this->hasOne(Employee::class,'id','pegawai_id');
    }

    function subGroups()
    {
    	return $this->hasOne(SubGroup::class,'id','sub_group_id');
    }
}
