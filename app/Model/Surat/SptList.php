<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\{Employee,WilayahTujuan};

class SptList extends Model
{
    //
    protected $fillable = ['wilayah_id','pimpinan_id','no_spt','tanggal','lama_waktu','tanggal_awal','tanggal_akhir','tempat_tujuan','maksud_tujuan','dasar1','dasar2','dasar3','need_action','file_spt_fix_url','employee_id'];
    protected $dates = ['tanggal','tanggal_awal','tanggal_akhir'];

    function employees()
    {
        return $this->hasMany(SptEmployee::class,'spt_id','id');
    }

    function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }

    function pimpinan()
    {
        return $this->hasOne(Employee::class,'id','pimpinan_id');
    }

    function sppds()
    {
        return $this->hasMany(SppdList::class,'spt_id','id');
    }

    function wilayah()
    {
        return $this->hasOne(WilayahTujuan::class,'id','wilayah_id');
    }

    public function hasAction($user_id)
    {
        return HistoriSptList::where('spt_id',$this->id)->where('user_id',$user_id)->orderby('id','desc')->first();
    }

    public function getLastHistoriAttribute()
    {
        return HistoriSptList::where('spt_id',$this->id)->orderby('id','desc')->first();
    }
    

}
