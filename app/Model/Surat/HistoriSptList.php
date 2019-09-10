<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;

class HistoriSptList extends Model
{
    //
    protected $fillable = ['user_id','spt_id','posisi','status','keterangan'];
    protected $dates = ['created_at','updated_at'];

    public function spt()
    {
    	return $this->hasOne(SptList::class,'id','spt_id');
    }

    public function employee()
    {
    	return $this->hasOne(Employee::class,'id','user_id');
    }
}
