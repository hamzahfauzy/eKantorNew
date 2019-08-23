<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['program_id','kd_kegiatan','nama','pagu_kegiatan'];

    function program()
    {
        return $this->hasOne(Program::class,'id','program_id');
    }
}
