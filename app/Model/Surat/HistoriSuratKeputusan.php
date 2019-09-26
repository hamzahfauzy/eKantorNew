<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;

class HistoriSuratKeputusan extends Model
{
    //
    protected $guarded = [];
    protected $dates = ['created_at','updated_at'];

    public function suratKeputusan()
    {
    	return $this->hasOne(SuratKeputusan::class,'id','surat_id');
    }

    public function employee()
    {
    	return $this->hasOne(Employee::class,'id','user_id');
    }
}
