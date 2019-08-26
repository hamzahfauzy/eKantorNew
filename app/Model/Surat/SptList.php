<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;

class SptList extends Model
{
    //
    protected $fillable = ['wilayah_id','pimpinan_id','no_spt','tanggal','lama_waktu','tanggal_awal','tanggal_akhir','tempat_tujuan','maksud_tujuan','dasar1','dasar2','dasar3'];
    protected $dates = ['tanggal','tanggal_awal','tanggal_akhir'];

    function employees()
    {
        return $this->hasMany(SptEmployee::class,'spt_id','id');
    }

    function sppds()
    {
        return $this->hasMany(SppdList::class,'spt_id','id');
    }
}
