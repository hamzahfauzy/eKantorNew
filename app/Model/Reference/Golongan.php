<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['nama','pangkat'];
}
