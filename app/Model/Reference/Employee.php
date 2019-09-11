<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\{Setting,Notification,Agenda};
use App\Model\Surat\{SuratMasuk, SuratKeluar, Disposisi, SptList, SppdList};

class Employee extends Model
{
    //
    protected $fillable = ['NIP','nama','jabatan','golongan_id','eselon_id','user_id','status_pptk'];

    public function golongan()
    {
    	return $this->hasOne(Golongan::class,'id','golongan_id');
    }

    public function kepala_group()
    {
        return $this->hasOne(Group::class,'kepala_id','id');
    }

    public function kepala_group_special_role()
    {
        $setting = Setting::find(1);
        if($this->kepala_group && $setting->special->group_id == $this->kepala_group->id)
            return 1;
        return 0;
    }

    public function kepala_sub_group()
    {
        return $this->hasOne(SubGroup::class,'kepala_id','id');
    }

    public function eselon()
    {
    	return $this->hasOne(Eselon::class,'id','eselon_id');
    }

    public function user()
    {
    	return $this->hasOne(User::class,'id','user_id');
    }

    public function staffGroup()
    {
        return $this->hasOne(SubGroupStaff::class,'pegawai_id','id');
    }

    public function inSpecialRole()
    {
        if($this->staffGroup)
        {
            $setting = Setting::find(1);
            if(!empty($setting))
                return $this->staffGroup->sub_group_id == $setting->group_special_role_id;
        }
        return 0;
    }

    public function inSpecialRoleUser()
    {
        if($this->staffGroup)
        {
            $setting = Setting::find(1);
            if(!empty($setting))
                return $this->staffGroup->sub_group_id == $setting->group_special_role_id && $this->id == $setting->group_special_role_user_id;
        }
        return 0;
    }

    public function isPimpinan()
    {
        $setting = Setting::find(1);
        if(!empty($setting))
            return $this->id == $setting->pimpinan_id;
        return 0;
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class,'user_id','id');
    }

    public function surat_keluars()
    {
        return $this->hasMany(SuratKeluar::class,'pegawai_id','id');
    }

    public function surat_masuks()
    {
        return $this->hasMany(SuratMasuk::class,'pegawai_id','id');
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class,'employee_id','id');
    }

    public function sptLists()
    {
        return $this->hasMany(SptList::class,'employee_id','id');
    }

    public function sppdLists()
    {
        return $this->hasMany(SppdList::class,'employee_id','id');
    }

    public function isPptk()
    {
        return $this->status_pptk;
        // return $this->hasOne(Kegiatan::class,'pptk_id','id');
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class,'pptk_id','id');
    }
}
