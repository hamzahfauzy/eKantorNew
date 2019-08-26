<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;

class SptNumber extends Model
{
    //
    protected $fillable = ['no_spt'];

    function list()
    {
        return $this->hasOne(SptList::class,'no_spt','no_spt');
    }
}
