<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\{Employee,SubGroup};

class Setting extends Model
{
    //

    public function pimpinan()
    {
    	return $this->hasOne(Employee::class,'id','pimpinan_id');
    }

    public function special()
    {
    	return $this->hasOne(SubGroup::class,'id','group_special_role_id');
    }
}
