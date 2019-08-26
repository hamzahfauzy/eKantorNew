<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    //
    protected $fillable = ['nama','status_maskapai'];
    public $timestamps = false;
}
