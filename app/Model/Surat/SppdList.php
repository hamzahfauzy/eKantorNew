<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;

class SppdList extends Model
{
    //
    protected $fillable = ['spt_id','tanggal','no_sppd','kegiatan_id','uang_harian','representatif','transport','penginapan','asal','tujuan','transportation_id'];
    protected $dates = ['tanggal'];

    function maskapai()
    {
        return $this->hasMany(SppdMaskapai::class,'sppd_id','id');
    }
}
