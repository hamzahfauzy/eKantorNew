<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $fillable = ['nama','kepala_id'];

    function kepala()
    {
    	return $this->hasOne(Employee::class,'id','kepala_id');
    }

    function subGroups()
    {
    	return $this->hasMany(SubGroup::class,'group_id','id');
    }
}
