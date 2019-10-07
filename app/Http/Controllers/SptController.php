<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Surat\{SptList, SptNumber, SptEmployee, HistoriSptList, ArsipSurat};
use App\Model\Reference\{WilayahTujuan, Employee};
use App\Model\{Setting,Notification,Agenda};

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
        $sptEmployee = SptEmployee::where('employee_id',auth()->user()->employee->id)->get();
        $model = [];
        foreach($sptEmployee as $spt)
        {
            $model[] = $spt->list;
        }

        $histori_surat = HistoriSptList::where('user_id',auth()->user()->employee->id)->where('status',0)->orderby('id','desc')->get();
        $surat_staffs = HistoriSptList::where('status',1)->orderby('id','desc')->get();
        return view('special-role.spt.spt-lists',[
            'spt' => $model,
            'spt_staffs' => auth()->user()->employee->inSpecialRole() ? $surat_staffs : $histori_surat,
        ]);
    }

    public function rekapitulasi()
    {
        //
        $from = $_GET['tanggal_awal'];
        $to = $_GET['tanggal_akhir'];
        
        $sptEmployee = SptEmployee::where('employee_id',auth()->user()->employee->id)->get();
        $model = [];
        foreach($sptEmployee as $spt)
        {
            $_model = $spt->list()->whereBetween('tanggal', [$from, $to])->first();
            if($_model != null)
                $model[] = $_model;
        }
        return view('special-role.spt.spt-rekapitulasi',[
            'setting' => Setting::first(),
            'tahun_anggaran' => $_GET['tahun_anggaran'],
            'spt' => $model
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
        $menugaskan = [];
        foreach($employees as $employee)
        {
            if($employee->isPimpinan())
                $menugaskan[] = $employee;
            
            if($employee->kepala_group_special_role())
                $menugaskan[] = $employee;
        }

        $employee = auth()->user()->employee;
        if($employee->kepala_sub_group)
        {
            $menugaskan[] = $employee->kepala_sub_group->group->kepala;
        }

        if($employee->staffGroup)
        {
            $menugaskan[] = $employee->staffGroup->subGroups->kepala;
            $menugaskan[] = $employee->staffGroup->subGroups->group->kepala;
        }

        return view('special-role.spt.create',[
            'spt' => $sptNumber,
            'wilayah' => $wilayah,
            'employees' => $menugaskan,
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
            // 'no_spt' => 'required|unique:spt_lists',
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
            'no_spt' => '',
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
            'employee_id' => auth()->user()->employee->id,
        ]);

        if(!in_array(auth()->user()->employee->id, $request->pengikut))
        {
            $sptEmployee = new SptEmployee;
            $sptEmployee->create([
                'spt_id' => $sptModel->id,
                'employee_id' => auth()->user()->employee->id,
            ]);
        }

        foreach($request->pengikut as $pengikut)
        {
            $sptEmployee = new SptEmployee;
            $sptEmployee->create([
                'spt_id' => $sptModel->id,
                'employee_id' => $pengikut,
            ]);
        }

        // For first run only
        // it's temporary and it will be deleted soon

        $setting = Setting::find(1);
        $pimpinan_id = $setting->pimpinan_id;
        $posisi = 1;

        $histori = HistoriSptList::create([
            'user_id' => $pimpinan_id,
            'spt_id' => $sptModel->id,
            'posisi' => $posisi,
            'status' => 1
        ]);

        $notification = new Notification;
        $notification->user_id = auth()->user()->employee->id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.spt.cetak',$sptModel->id);
        $notification->deskripsi = "SPT Diterima oleh ".$histori->employee->nama." (".$histori->employee->jabatan.")";
        $notification->save();
        
        $sptModel->update(['need_action' => -1]);
        foreach($sptModel->employees as $employee)
        {
            $agenda = new Agenda;
            $agenda->create([
                'employee_id' => $employee->employee_id,
                'tanggal_awal' => $sptModel->tanggal_awal,
                'tanggal_akhir' => $sptModel->tanggal_akhir,
                'waktu_mulai' => '',
                'waktu_selesai' => '',
                'kegiatan' => $sptModel->maksud_tujuan,
                'tempat' => $sptModel->tempat_tujuan,
                'keterangan' => 'PT',
                'file_url' => '',
                'status' => 1
            ]); 
        }

        return redirect()->route('pegawai.spt.index')->with(['success'=>'Data berhasil disimpan']);

        // end

        $pimpinan_id = 0;
        $posisi = 4;
        if(auth()->user()->employee->staffGroup)
        {
            $pimpinan_id = auth()->user()->employee->staffGroup->subGroups->kepala_id;            
        }
        elseif (auth()->user()->employee->kepala_sub_group) 
        {
            $pimpinan_id = auth()->user()->employee->kepala_sub_group->group->kepala_id;
            $posisi = 3;
        }
        elseif (auth()->user()->employee->kepala_group) 
        {
            $employees = Employee::get();
            foreach ($employees as $employee) {
                if($employee->kepala_group_special_role())
                {
                    $pimpinan_id = $employee->id;
                    break;
                }
            }
            if(auth()->user()->employee->id != $pimpinan_id)
                $posisi = 2;
            else
            {
                $setting = Setting::find(1);
                $pimpinan_id = $setting->pimpinan_id;
                $posisi = 1;
            }
        }

        HistoriSptList::create([
            'user_id' => $pimpinan_id,
            'spt_id' => $sptModel->id,
            'posisi' => $posisi,
            'status' => 0
        ]);

        $this->model->find($sptModel->id)->update(['need_action' => $posisi]);

        $notification = new Notification;
        $notification->user_id = $pimpinan_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.spt.cetak',$sptModel->id);
        $notification->deskripsi = "SPT - Dari ".auth()->user()->name." (".auth()->user()->employee->jabatan.")";
        $notification->save();

        return redirect()->route('pegawai.spt.index')->with(['success'=>'Data berhasil disimpan']);

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

        $menugaskan = [];
        foreach($employees as $employee)
        {
            if($employee->isPimpinan())
                $menugaskan[] = $employee;
            
            if($employee->kepala_group_special_role())
                $menugaskan[] = $employee;
        }

        $employee = auth()->user()->employee;
        if($employee->kepala_sub_group)
        {
            $menugaskan[] = $employee->kepala_sub_group->group->kepala;
        }

        if($employee->staffGroup)
        {
            $menugaskan[] = $employee->staffGroup->subGroups->kepala;
            $menugaskan[] = $employee->staffGroup->subGroups->group->kepala;
        }
        return view('special-role.spt.edit',[
            'sptModel' => $spt,
            'wilayah' => $wilayah,
            'employees' => $menugaskan,
            'pengikut' => $employees,
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
            // 'no_spt' => 'required|unique:spt_lists,no_spt,'.$request->id.',id',
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

        $model = $this->model->find($request->id)->update([
            'no_spt' => '',
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
        if(!in_array(auth()->user()->employee->id, $request->pengikut))
        {
            $sptEmployee = new SptEmployee;
            $sptEmployee->create([
                'spt_id' => $sptModel->id,
                'employee_id' => auth()->user()->employee->id,
            ]);
        }
        foreach($request->pengikut as $pengikut)
        {
            $sptEmployee = new SptEmployee;
            $sptEmployee->create([
                'spt_id' => $request->id,
                'employee_id' => $pengikut,
            ]);
        }

        $pimpinan_id = 0;
        $posisi = 4;
        if(auth()->user()->employee->staffGroup)
        {
            $pimpinan_id = auth()->user()->employee->staffGroup->subGroups->kepala_id;            
        }
        elseif (auth()->user()->employee->kepala_sub_group) 
        {
            $pimpinan_id = auth()->user()->employee->kepala_sub_group->group->kepala_id;
            $posisi = 3;
        }
        elseif (auth()->user()->employee->kepala_group) 
        {
            $employees = Employee::get();
            foreach ($employees as $employee) {
                if($employee->kepala_group_special_role())
                {
                    $pimpinan_id = $employee->id;
                    break;
                }
            }
            if(auth()->user()->employee->id != $pimpinan_id)
                $posisi = 2;
            else
            {
                $setting = Setting::find(1);
                $pimpinan_id = $setting->pimpinan_id;
                $posisi = 1;
            }
        }

        HistoriSptList::create([
            'user_id' => $pimpinan_id,
            'spt_id' => $request->id,
            'posisi' => $posisi,
            'status' => 0
        ]);

        $this->model->find($request->id)->update(['need_action' => $posisi]);

        $notification = new Notification;
        $notification->user_id = $pimpinan_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.spt.cetak',$request->id);
        $notification->deskripsi = "Update SPT - Dari ".auth()->user()->name." (".auth()->user()->employee->jabatan.")";
        $notification->save();

        return redirect()->route('pegawai.spt.index')->with(['success'=>'Data berhasil diupdate']);
    }

    function doUpdate(Request $request)
    {
        $pimpinan_id = 0;
        $posisi = 4;
        if(auth()->user()->employee->staffGroup)
        {
            $pimpinan_id = auth()->user()->employee->staffGroup->subGroups->kepala_id;            
        }
        elseif (auth()->user()->employee->kepala_sub_group) 
        {
            $pimpinan_id = auth()->user()->employee->kepala_sub_group->group->kepala_id;
            $posisi = 3;
        }
        elseif (auth()->user()->employee->kepala_group) 
        {
            $employees = Employee::get();
            foreach ($employees as $employee) {
                if($employee->kepala_group_special_role())
                {
                    $pimpinan_id = $employee->id;
                    break;
                }
            }
            if(auth()->user()->employee->id != $pimpinan_id)
                $posisi = 2;
            else
            {
                $setting = Setting::find(1);
                $pimpinan_id = $setting->pimpinan_id;
                $posisi = 1;
            }
        }

        HistoriSptList::create([
            'user_id' => $pimpinan_id,
            'spt_id' => $request->id,
            'posisi' => $posisi,
            'status' => 0
        ]);

        $this->model->find($request->id)->update(['need_action' => $posisi]);

        $notification = new Notification;
        $notification->user_id = $pimpinan_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.spt.cetak',$request->id);
        $notification->deskripsi = "Update SPT - Dari ".auth()->user()->name." (".auth()->user()->employee->jabatan.")";
        $notification->save();

        return redirect()->route('pegawai.spt.index')->with(['success'=>'Data berhasil diupdate']);
    }

    public function accept(Request $request)
    {
        $histori = HistoriSptList::find($request->id);
        $surat = SptList::find($histori->spt_id);
        HistoriSptList::create([
            'user_id' => $histori->user_id,
            'spt_id' => $histori->spt_id,
            'posisi' => $histori->posisi,
            'status' => 1,
        ]);

        $notification = new Notification;
        $notification->user_id = $surat->employee_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.spt.cetak',$surat->id);
        $notification->deskripsi = "SPT Diterima oleh ".$histori->employee->nama." (".$histori->employee->jabatan.")";
        $notification->save();

        $pimpinan_id = 0;

        if($histori->posisi == 1)
        {
            $surat->update(['need_action' => -1]);
            foreach($surat->employees as $employee)
            {
                $agenda = new Agenda;
                $agenda->create([
                    'employee_id' => $employee->employee_id,
                    'tanggal_awal' => $surat->tanggal_awal,
                    'tanggal_akhir' => $surat->tanggal_akhir,
                    'waktu_mulai' => '',
                    'waktu_selesai' => '',
                    'kegiatan' => $surat->maksud_tujuan,
                    'tempat' => $surat->tempat_tujuan,
                    'keterangan' => '',
                    'file_url' => '',
                    'status' => 1
                ]); 
            }
            return redirect()->route('pegawai.spt.index')->with(['success'=>'Data berhasil disimpan']);
        }

        $posisi = 4;
        if (auth()->user()->employee->kepala_sub_group) 
        {
            $pimpinan_id = auth()->user()->employee->kepala_sub_group->group->kepala_id;
            $posisi = 3;
        }
        elseif (auth()->user()->employee->kepala_group) 
        {
            $employees = Employee::get();
            foreach ($employees as $employee) {
                if($employee->kepala_group_special_role())
                {
                    $pimpinan_id = $employee->id;
                    break;
                }
            }
            if(auth()->user()->employee->id != $pimpinan_id)
                $posisi = 2;
            else
            {
                $setting = Setting::find(1);
                $pimpinan_id = $setting->pimpinan_id;
                $posisi = 1;
            }
        }

        if($posisi >= 1)
        {
            if(auth()->user()->employee->id == $surat->pimpinan_id)
            {
                $surat->update(['need_action' => -1]);   
                foreach($surat->employees as $employee)
                {
                    $agenda = new Agenda;
                    $agenda->create([
                        'employee_id' => $employee->employee_id,
                        'tanggal_awal' => $surat->tanggal_awal,
                        'tanggal_akhir' => $surat->tanggal_akhir,
                        'waktu_mulai' => '',
                        'waktu_selesai' => '',
                        'kegiatan' => $surat->maksud_tujuan,
                        'tempat' => $surat->tempat_tujuan,
                        'keterangan' => 'SPT',
                        'file_url' => '',
                        'status' => 1
                    ]);
                }
                
                return redirect()->route('pegawai.spt.index')->with(['success'=>'Data berhasil disimpan']);
            }

            HistoriSptList::create([
                'user_id' => $pimpinan_id,
                'spt_id' => $histori->spt_id,
                'posisi' => $posisi,
                'status' => 0
            ]);
            $this->model->find($histori->spt_id)->update(['need_action' => $posisi]);
            $notification = new Notification;
            $notification->user_id = $pimpinan_id;
            $notification->status = 0;
            $notification->url_to = route('pegawai.spt.cetak',$histori->spt_id);
            $notification->deskripsi = "SPT - Dari ".$histori->spt->employee->nama." (".$histori->spt->employee->jabatan.")";
            $notification->save();
        }
        else
        {
            $this->model->find($histori->spt_id)->update(['need_action' => -1]);
        }

        return redirect()->route('pegawai.spt.index')->with(['success'=>'Data berhasil disimpan']);

    }

    public function decline(Request $request)
    {
        $histori = HistoriSptList::find($request->id);
        $surat = SptList::find($histori->spt_id);
        HistoriSptList::create([
            'user_id' => $histori->user_id,
            'spt_id' => $histori->spt_id,
            'posisi' => $histori->posisi,
            'status' => 2,
            'keterangan' => $request->catatan,
        ]);

        $posisi = 0;

        $this->model->find($surat->id)->update(['need_action' => $posisi]);

        $notification = new Notification;
        $notification->user_id = $surat->employee_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.spt.cetak',$histori->spt_id);
        $notification->deskripsi = "SPT Ditolak oleh ".$histori->employee->nama." (".$histori->employee->jabatan.")";
        $notification->save();

        return redirect()->route('pegawai.spt.index')->with(['success'=>'Data berhasil disimpan']);

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
        return redirect()->route('pegawai.spt.index')->with(['success'=>'Data berhasil dihapus']);
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

    public function upload(Request $request)
    {
        $surat = SptList::find($request->id);
        if(!empty($request->file('file_spt_fix_url')))
        {
            $uploadedFile = $request->file('file_spt_fix_url');
            $path = $uploadedFile->store('public/spt');
            $surat->file_spt_fix_url = $path;
            $surat->save();
        }
        return redirect()->route('pegawai.spt.index')->with(['success'=>'Surat berhasil di upload']);
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

    public function arsip(Request $request)
    {
        $arsip = new ArsipSurat;
        $arsip->surat_id = $request->id;
        $arsip->no_arsip = $request->no_arsip;
        $arsip->jenis_surat = "SPT";
        $arsip->tipe_arsip = $request->tipe_arsip;
        $arsip->save();
        HistoriSptList::create([
            'user_id' => auth()->user()->employee->id,
            'spt_id' => $request->id,
            'posisi' => 0,
            'status' => 4
        ]);
        return redirect()->route('pegawai.spt.index')->with(['success'=>'Surat telah di arsipkan']);
    }
}
