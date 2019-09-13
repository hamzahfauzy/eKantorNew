<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reference\Employee;

class Agenda extends Model
{
    //
    protected $fillable = ['employee_id','tanggal_awal','tanggal_akhir','waktu_mulai','waktu_selesai','kegiatan','tempat','keterangan','file_url','status'];

    function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }
}
