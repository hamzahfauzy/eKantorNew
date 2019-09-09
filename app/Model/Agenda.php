<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    //
    protected $fillable = ['employee_id','tanggal_awal','tanggal_akhir','waktu_mulai','waktu_selesai','kegiatan','tempat','keterangan','file_url'];
}
