<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Reference\{Employee, Group};
use App\Model\Setting;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->employees = Employee::get();
        $this->groups = Group::get();
        $this->model = Setting::find(1);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('setting',[
            'pimpinan' => $this->employees,
            'groups' => $this->groups,
            'model' => $this->model,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $this->validate($request,[
            'nama' => 'required',
            'alamat' => 'required',
            'pimpinan_id' => 'required',
            'group_special_role_id' => 'required',
        ]);
        $setting = Setting::find(1);
        if(empty($setting))
            $setting = new Setting;

        $setting->nama = $request->nama;
        $setting->alamat = $request->alamat;
        $setting->pimpinan_id = $request->pimpinan_id;
        $setting->group_special_role_id = $request->group_special_role_id;
        $setting->save();

        if(!empty($request->file('logo')))
        {
            $uploadedFile = $request->file('logo');
            $path = $uploadedFile->store('public/setting');

            $setting->logo = $path;
            $setting->save();
        }

        return redirect()->route('setting.index')->with(['success'=>'Data berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
