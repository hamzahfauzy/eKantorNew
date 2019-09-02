<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\{Employee,WilayahTujuan};

class SptList extends Model
{
    //
    protected $fillable = ['wilayah_id','pimpinan_id','no_spt','tanggal','lama_waktu','tanggal_awal','tanggal_akhir','tempat_tujuan','maksud_tujuan','dasar1','dasar2','dasar3'];
    protected $dates = ['tanggal','tanggal_awal','tanggal_akhir'];

    function employees()
    {
        return $this->hasMany(SptEmployee::class,'spt_id','id');
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

}
