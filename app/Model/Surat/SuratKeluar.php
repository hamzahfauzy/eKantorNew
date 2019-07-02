<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\{Employee, SubGroup};

class SuratKeluar extends Model
{
    //
    protected $fillable = ['no_surat','tanggal','sub_group_id','tujuan','perihal','keterangan','file_surat_url','pegawai_id'];
    protected $dates = ['tanggal','created_at','updated_at'];

    public function employee()
    {
    	return $this->hasOne(Employee::class,'id','pegawai_id');
    }

    public function pengelola()
    {
    	return $this->hasOne(SubGroup::class,'id','sub_group_id');
    }
}
