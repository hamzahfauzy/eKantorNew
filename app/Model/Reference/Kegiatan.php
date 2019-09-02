<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;
use App\Model\Surat\SppdList;

class Kegiatan extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['program_id','kd_kegiatan','nama','pagu_kegiatan','pptk_id'];

    function getPaguAttribute()
    {
        $total = 0;
        foreach($this->sppds as $sppd)
            $total += $sppd->total_biaya;
        return $this->pagu_kegiatan - $total;
    }

    function program()
    {
        return $this->hasOne(Program::class,'id','program_id');
    }

    function sppds()
    {
        return $this->hasMany(SppdList::class,'kegiatan_id','id');
    }

    function pptk()
    {
        return $this->hasOne(Employee::class,'id','pptk_id');
    }
}
