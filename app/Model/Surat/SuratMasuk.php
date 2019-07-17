<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;

class SuratMasuk extends Model
{
    //
    protected $fillable = ['no_agenda','no_surat','tanggal_surat','tanggal_terima','sumber_surat','perihal','keterangan','file_url_surat','pegawai_id','status_teruskan','sifat_surat'];
    protected $dates = ['tanggal_surat','tanggal_terima','created_at','updated_at'];

    public function disposisis()
    {
    	return $this->hasMany(Disposisi::class,'surat_masuk_id','id');
    }

    public function employee()
    {
    	return $this->hasOne(Employee::class,'id','pegawai_id');
    }

    public function histori()
    {
        return $this->hasMany(HistoriSuratMasuk::class,'surat_masuk_id','id');
    }

    public function getArsipAttribute()
    {
        return ArsipSurat::where('surat_id',$this->id)->where('jenis_surat','Surat Masuk')->first();
    }
}
