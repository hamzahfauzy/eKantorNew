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
        return $this->pagu_kegiatan - ($this->sppds()->sum('uang_harian') + $this->sppds()->sum('representatif') + $this->sppds()->sum('transport') + $this->sppds()->sum('penginapan'));
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
