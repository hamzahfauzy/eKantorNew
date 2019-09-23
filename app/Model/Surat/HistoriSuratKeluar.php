<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;

class HistoriSuratKeluar extends Model
{
    //
    protected $fillable = ['user_id','surat_id','posisi','status','keterangan','pdf_serialize'];
    protected $dates = ['created_at','updated_at'];

    public function suratKeluar()
    {
    	return $this->hasOne(SuratKeluar::class,'id','surat_id');
    }

    public function employee()
    {
    	return $this->hasOne(Employee::class,'id','user_id');
    }
}
