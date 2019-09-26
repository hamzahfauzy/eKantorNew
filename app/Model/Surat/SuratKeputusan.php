<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\{Employee, SubGroup};

class SuratKeputusan extends Model
{
    //
    protected $guarded = [];
    protected $dates = ['tanggal','created_at','updated_at'];

    public function employee()
    {
    	return $this->hasOne(Employee::class,'id','pegawai_id');
    }

    public function historis()
    {
        return $this->hasMany(HistoriSuratKeputusan::class,'surat_id','id');
    }

    public function hasAction($user_id)
    {
        return HistoriSuratKeputusan::where('surat_id',$this->id)->where('user_id',$user_id)->orderby('id','desc')->first();
    }

    public function getLastHistoriAttribute()
    {
        return HistoriSuratKeputusan::where('surat_id',$this->id)->orderby('id','desc')->first();
    }

    public function getArsipPegawaiAttribute()
    {
        $model = ArsipSurat::where('surat_id',$this->id)->where('jenis_surat','Surat Keputusan')->where('tipe_arsip','arsip pegawai')->first();
        return $model;
    }

    public function getArsipOperatorAttribute()
    {
        $model = ArsipSurat::where('surat_id',$this->id)->where('jenis_surat','Surat Keputusan')->where('tipe_arsip','arsip operator')->first();
        return $model;
    }
}
