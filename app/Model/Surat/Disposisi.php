<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;

class Disposisi extends Model
{
    //
    protected $fillable = ['surat_masuk_id','pegawai_id','catatan'];

    public function surat_masuk()
    {
    	return $this->hasOne(SuratMasuk::class,'id','surat_masuk_id');
    }

    public function employee()
    {
    	return $this->hasOne(Employee::class,'id','pegawai_id');
    }
}
