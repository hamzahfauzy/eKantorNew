<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['kd_program','nama'];

    function kegiatans()
    {
        return $this->hasMany(Kegiatan::class,'program_id','id');
    }
}
