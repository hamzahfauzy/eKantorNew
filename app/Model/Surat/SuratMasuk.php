<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;

class SuratMasuk extends Model
{
    //
    protected $fillable = ['no_agenda','no_surat','tanggal_surat','tanggal_terima','sumber_surat','perihal','keterangan','file_url_surat','pegawai_id'];
    protected $dates = ['tanggal_surat','tanggal_terima','created_at','updated_at'];

    public function disposisis()
    {
    	return $this->hasMany(Disposisi::class,'surat_masuk_id','id');
    }

    public function employee()
    {
    	return $this->hasOne(Employee::class,'id','pegawai_id');
    }
}
