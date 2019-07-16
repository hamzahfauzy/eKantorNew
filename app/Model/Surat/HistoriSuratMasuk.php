<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;

class HistoriSuratMasuk extends Model
{
    //
    protected $fillable = ['surat_masuk_id','status'];
    protected $dates = ['created_at','updated_at'];
}
