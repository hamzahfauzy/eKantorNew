<?php

namespace App\Http\Controllers\SpecialRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Surat\{SptList, SptNumber, SptEmployee};
use App\Model\Reference\{WilayahTujuan, Employee};
use App\Model\Setting;

class SptController extends Controller
{
    function __construct()
    {
        $this->model = new SptList;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('special-role.spt.index',[
            'spt' => $this->model->get()
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
        $sptNumber = SptNumber::get();
        $wilayah = WilayahTujuan::get();
        $employees = Employee::get();
        return view('special-role.spt.create',[
            'spt' => $sptNumber,
            'wilayah' => $wilayah,
            'employees' => $employees,
        ]);
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
        $this->validate($request,[
            'no_spt' => 'required',
            'wilayah_id' => 'required',
            'tanggal' => 'required',
            'lama_waktu' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
            'tempat_tujuan' => 'required',
            'maksud_tujuan' => 'required',
            'dasar1' => 'required',
            'dasar2' => 'required',
            'dasar3' => 'required',
        ]);

        $sptModel = $this->model->create([
            'no_spt' => $request->no_spt,
            'pimpinan_id' => $request->pimpinan_id,
            'wilayah_id' => $request->wilayah_id,
            'tanggal' => $request->tanggal,
            'lama_waktu' => $request->lama_waktu,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'tempat_tujuan' => $request->tempat_tujuan,
            'maksud_tujuan' => $request->maksud_tujuan,
            'dasar1' => $request->dasar1,
            'dasar2' => $request->dasar2,
            'dasar3' => $request->dasar3,
        ]);

        foreach($request->pengikut as $pengikut)
        {
            $sptEmployee = new SptEmployee;
            $sptEmployee->create([
                'spt_id' => $sptModel->id,
                'employee_id' => $pengikut,
            ]);
        }

        return redirect()->route('pegawai.spt-role.index')->with(['success'=>'Data berhasil disimpan']);
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
    public function edit(SptList $spt)
    {
        //
        $wilayah = WilayahTujuan::get();
        $employees = Employee::get();
        $sptEmployee = [];
        foreach($spt->employees as $employee)
            $sptEmployee[] = $employee->employee_id;
        return view('special-role.spt.edit',[
            'sptModel' => $spt,
            'wilayah' => $wilayah,
            'employees' => $employees,
            'sptEmployee' => $sptEmployee
        ]);
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
        $this->model->find($request->id)->update([
            'no_spt' => $request->no_spt,
            'pimpinan_id' => $request->pimpinan_id,
            'wilayah_id' => $request->wilayah_id,
            'tanggal' => $request->tanggal,
            'lama_waktu' => $request->lama_waktu,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'tempat_tujuan' => $request->tempat_tujuan,
            'maksud_tujuan' => $request->maksud_tujuan,
            'dasar1' => $request->dasar1,
            'dasar2' => $request->dasar2,
            'dasar3' => $request->dasar3,
        ]);

        SptEmployee::where('spt_id',$request->id)->delete();
        foreach($request->pengikut as $pengikut)
        {
            $sptEmployee = new SptEmployee;
            $sptEmployee->create([
                'spt_id' => $request->id,
                'employee_id' => $pengikut,
            ]);
        }

        return redirect()->route('pegawai.spt-role.index')->with(['success'=>'Data berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $spt = $this->model->find($request->id);
        $spt->delete();

        return redirect()->route('pegawai.spt-role.index')->with(['success'=>'Data berhasil dihapus']);
    }

    public function cetak(SptList $spt)
    {
        $setting = Setting::first();
        return view('special-role.spt.cetak',[
            'spt' => $spt,
            'setting' => $setting
        ]);
    }
}
