<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Transportation;

class SppdList extends Model
{
    //
    protected $fillable = ['spt_id','tanggal','no_sppd','kegiatan_id','asal','tujuan','transportation_id','employee_id'];
    protected $dates = ['tanggal'];

    function maskapai()
    {
        return $this->hasMany(SppdMaskapai::class,'sppd_id','id');
    }

    function spt()
    {
        return $this->hasOne(SptList::class, 'id', 'spt_id');
    }

    function transportation()
    {
        return $this->hasOne(Transportation::class,'id','transportation_id');
    }

    function employees()
    {
        return $this->hasMany(SppdEmployee::class,'sppd_id','id');
    }

    function getTotalBiayaAttribute()
    {
        $total = 0;
        foreach($this->employees as $employee)
            $total += $employee->total_biaya;
        return $total;
    }

    function getMaskapaiBerangkatAttribute()
    {
        $model = SppdMaskapai::where('sppd_id',$this->id)->where('status_keberangkatan',1)->first();
        return $model;
    }

    function getMaskapaiKembaliAttribute()
    {
        $model = SppdMaskapai::where('sppd_id',$this->id)->where('status_keberangkatan',2)->first();
        return $model;
    }
}
