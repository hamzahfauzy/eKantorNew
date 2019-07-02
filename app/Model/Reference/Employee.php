<?php

namespace App\Model\Reference;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Setting;
use App\Model\Surat\{SuratMasuk, Disposisi};

class Employee extends Model
{
    //
    protected $fillable = ['NIP','nama','jabatan','golongan_id','eselon_id','user_id'];

    public function golongan()
    {
    	return $this->hasOne(Golongan::class,'id','golongan_id');
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

    public function isPimpinan()
    {
        $setting = Setting::find(1);
        if(!empty($setting))
            return $this->id == $setting->pimpinan_id;
        return 0;
    }

    public function notifications()
    {
        if($this->isPimpinan())
            $ret = SuratMasuk::get();
        else
            $ret = Disposisi::where('pegawai_id',$this->id)->get();
        
        return $ret;
    }
}
