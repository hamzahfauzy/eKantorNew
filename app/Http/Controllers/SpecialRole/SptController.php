<?php

namespace App\Http\Controllers\SpecialRole;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\Surat\{SptList, SptNumber, SptEmployee};
use App\Model\Reference\{WilayahTujuan, Employee};
use App\Model\Setting;
use PDF;

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
        $employees = Employee::get();
        return view('special-role.spt.index',[
            'spt' => $this->model->get(),
            'employees' => $employees
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
        $customMessages = [
            'unique' => ':attribute sudah digunakan.'
        ];
        $this->validate($request,[
            'no_spt' => 'required|unique:spt_lists',
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
        ],$customMessages);

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
        $this->validate($request,[
            'no_spt' => 'required|unique:spt_lists,no_spt,'.$request->id.',id',
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

    public function setUrutan(Request $request)
    {
        SptEmployee::find($request->id)->update([
            'no_urut' => $request->urutan
        ]);

        return 1;
    }

    public function setNoSpt(Request $request)
    {
        SptList::find($request->id)->update([
            'no_spt' => $request->no_spt,
            'tanggal' => $request->tanggal,
        ]);

        $surat = SptList::find($request->id);
        if(!empty($request->file('file_spt_fix_url')))
        {
            $uploadedFile = $request->file('file_spt_fix_url');
            $path = $uploadedFile->store('public/spt');
            $surat->file_spt_fix_url = $path;
            $surat->save();
        }

        return redirect()->route('pegawai.spt-role.index')->with(['success'=>'No SPT berhasil di tambahkan']);
    }

    public function getEmployees(Request $request)
    {
        $employeesModel = Employee::get();
        $existingSpt = SptList::whereBetween('tanggal_awal',[$request->tanggal_awal,$request->tanggal_akhir])->orwhereBetween('tanggal_akhir',[$request->tanggal_awal,$request->tanggal_akhir])->get();
        $showEmployee = [];
        if(!empty($existingSpt) && count($existingSpt) > 0)
        {
            $existingEmployees = [];
            foreach($existingSpt as $spt)
            {
                foreach($spt->employees as $employee)
                {
                    if(isset($request->id) && $spt->id == $request->id)
                        continue;

                    $existingEmployees[] = $employee->employee_id;
                }
            }

            foreach($employeesModel as $employee)
                if(!in_array($employee->id,$existingEmployees))
                    $showEmployee[] = $employee;
        }
        else
        {
            foreach($employeesModel as $employee)
                $showEmployee[] = $employee;
        }

        // if(isset($request->id))
        // {
        //     $SptEmployee = SptEmployee::where('spt_id',$request->id)->get();
        //     foreach($SptEmployee as $employee)
        //         $showEmployee[] = $employee->employee;
            
        // }

        return response()->json(["error" => 0, "message" => "data found", "data" => $showEmployee]);
    }

    public function rekapitulasi()
    {
        //
        $setting = Setting::first();
        // $pdf = PDF::loadview('special-role.spt.rekapitulasi',[
        //     'spt' => $this->model->get(),
        //     'setting' => $setting
        // ]);

        $from = $_GET['tanggal_awal'];
        $to = $_GET['tanggal_akhir'];
        $model = $this->model->whereBetween('tanggal', [$from, $to])->get();

        return view('special-role.spt.rekapitulasi',[
            'spt' => $model,
            'employee_id' => $_GET['employee_id'],
            'tahun_anggaran' => $_GET['tahun_anggaran'],
            'setting' => $setting
        ]);

        // $pdf->stream();
    }

    public function arsip(Request $request)
    {
        $arsip = new ArsipSurat;
        $arsip->surat_id = $request->id;
        $arsip->no_arsip = $request->no_arsip;
        $arsip->jenis_surat = "SPT";
        $arsip->tipe_arsip = $request->tipe_arsip;
        $arsip->save();
        return redirect()->route('pegawai.spt-role.index')->with(['success'=>'Surat telah di arsipkan']);
    }
}
