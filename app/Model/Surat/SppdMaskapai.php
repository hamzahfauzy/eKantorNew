<?php

namespace App\Model\Surat;

use Illuminate\Database\Eloquent\Model;

class SppdMaskapai extends Model
{
    //
    protected $fillable = ['sppd_id','nama_maskapai','no_tiket','id_booking','tanggal_checkin','harga_tiket','status_keberangkatan'];

}
