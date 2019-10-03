<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Surat\{SuratKeluar,HistoriSuratKeluar, ArsipSurat};
use App\Model\Reference\{SubGroup,Employee};
use App\Model\{Notification,Setting};

class SuratKeluarController extends Controller
{
    public function __construct()
    {
        $this->model = new SuratKeluar;
        $this->sub_group = SubGroup::get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $histori_surat = HistoriSuratKeluar::where('user_id',auth()->user()->employee->id)->where('status',0)->orderby('id','desc')->get();
        $surat_staffs = HistoriSuratKeluar::where('status',1)->orderby('id','desc')->get();
        return view('special-role.surat-keluar.index',[
            'surat' => $this->model->where('pegawai_id',auth()->user()->employee->id)->orderby('id','desc')->get(),
            'surat_staffs' => auth()->user()->employee->inSpecialRole() ? $surat_staffs : $histori_surat,
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
        return view('special-role.surat-keluar.create',[
            'subgroups' => $this->sub_group
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
            'no_surat' => 'required|unique:surat_keluars',
            'tanggal_surat' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'keterangan' => 'required',
            'file_surat' => 'required|mimes:pdf',
        ]);

        $uploadedFile = $request->file('file_surat');
        $path = $uploadedFile->store('public/surat_keluar');

        $model = $this->model->create([
            'no_surat' => $request->no_surat,
            'tanggal' => $request->tanggal_surat,
            'tujuan' => $request->tujuan,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'file_surat_url' => $path,
            'pegawai_id' => auth()->user()->employee->id,
        ]);

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

        HistoriSuratKeluar::create([
            'user_id' => $pimpinan_id,
            'surat_id' => $model->id,
            'posisi' => $posisi,
            'status' => 0
        ]);

        $this->model->find($model->id)->update(['need_action' => $posisi]);

        $notification = new Notification;
        $notification->user_id = $pimpinan_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.surat-keluar.show',$model->id);
        $notification->deskripsi = "Surat Keluar - Dari ".auth()->user()->name." (".auth()->user()->employee->jabatan.")";
        $notification->save();

        return redirect()->route('pegawai.surat-keluar.index')->with(['success'=>'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SuratKeluar $surat)
    {
        //
        return view('special-role.surat-keluar.show',[
            'surat' => $surat
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SuratKeluar $surat)
    {
        //
        return view('special-role.surat-keluar.edit',[
            'surat' => $surat,
            'subgroups' => $this->sub_group
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
            'no_surat' => 'required|unique:surat_keluars,no_surat,'.$request->id.',id,no_surat,'.$request->no_surat,
            'tanggal_surat' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'keterangan' => 'required',
        ]);

        $path = "";
        if(!empty($request->file('file_surat')))
        {
            $this->validate($request,[
                'file_surat' => 'required|mimes:pdf'
            ]);
            $uploadedFile = $request->file('file_surat');
            $path = $uploadedFile->store('public/surat_keluar');
            $this->model->find($request->id)->update([
                'file_surat_url' => $path,
            ]);
        }

        $this->model->find($request->id)->update([
            'no_surat' => $request->no_surat,
            'tanggal' => $request->tanggal_surat,
            'tujuan' => $request->tujuan,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'pegawai_id' => auth()->user()->employee->id,
        ]);

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

        HistoriSuratKeluar::create([
            'user_id' => $pimpinan_id,
            'surat_id' => $request->id,
            'posisi' => $posisi,
            'status' => 0
        ]);

        $this->model->find($request->id)->update(['need_action' => $posisi]);

        $notification = new Notification;
        $notification->user_id = $pimpinan_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.surat-keluar.show',$request->id);
        $notification->deskripsi = "Update Surat Keluar - Dari ".auth()->user()->name." (".auth()->user()->employee->jabatan.")";
        $notification->save();

        return redirect()->route('pegawai.surat-keluar.index')->with(['success'=>'Data berhasil diupdate']);
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
        $this->model->find($request->id)->delete();
        return redirect()->route('pegawai.surat-keluar.index')->with(['success'=>'Data berhasil dihapus']);

    }

    public function accept(Request $request)
    {
        $histori = HistoriSuratKeluar::find($request->id);
        $surat = SuratKeluar::find($histori->surat_id);
        HistoriSuratKeluar::create([
            'user_id' => $histori->user_id,
            'surat_id' => $histori->surat_id,
            'posisi' => $histori->posisi,
            'status' => 1,
        ]);

        $notification = new Notification;
        $notification->user_id = $surat->pegawai_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.surat-keluar.show',$surat->id);
        $notification->deskripsi = "Surat Diterima oleh ".$histori->employee->nama." (".$histori->employee->jabatan.")";
        $notification->save();

        $pimpinan_id = 0;
        $posisi = $histori->posisi;
        if($posisi == 1)
        {
            $surat->update(['need_action' => -1]);   
            return redirect()->route('pegawai.surat-keluar.index')->with(['success'=>'Data berhasil disimpan']);
        }
        
        if (auth()->user()->employee->kepala_sub_group) 
        {
            $pimpinan_id = auth()->user()->employee->kepala_sub_group->group->kepala_id;
            $posisi = $posisi - 1;
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
            HistoriSuratKeluar::create([
                'user_id' => $pimpinan_id,
                'surat_id' => $histori->surat_id,
                'posisi' => $posisi,
                'status' => 0
            ]);
            $this->model->find($histori->surat_id)->update(['need_action' => $posisi]);
            $notification = new Notification;
            $notification->user_id = $pimpinan_id;
            $notification->status = 0;
            $notification->url_to = route('pegawai.surat-keluar.show',$histori->surat_id);
            $notification->deskripsi = "Surat Keluar - Dari ".$histori->suratKeluar->employee->nama." (".$histori->suratKeluar->employee->jabatan.")";
            $notification->save();
        }
        else
        {
            $this->model->find($histori->surat_id)->update(['need_action' => -1]);
        }

        return redirect()->route('pegawai.surat-keluar.index')->with(['success'=>'Data berhasil disimpan']);

    }

    public function declineEditor(HistoriSuratKeluar $histori)
    {
        $surat = SuratKeluar::find($histori->surat_id);
        return view('special-role.surat-keluar.decline-editor',[
            'surat' => $surat,
            'histori' => $histori
        ]);
    }

    public function declineViewer(HistoriSuratKeluar $histori)
    {
        $surat = SuratKeluar::find($histori->surat_id);
        return view('special-role.surat-keluar.decline-viewer',[
            'surat' => $surat,
            'histori' => $histori
        ]);
    }

    public function decline(Request $request)
    {
        $histori = HistoriSuratKeluar::find($request->id);
        $surat = SuratKeluar::find($histori->surat_id);
        HistoriSuratKeluar::create([
            'user_id' => $histori->user_id,
            'surat_id' => $histori->surat_id,
            'posisi' => $histori->posisi,
            'status' => 2,
            'keterangan' => $request->catatan,
            'pdf_serialize' => serialize(json_decode($request->pdfData))
        ]);

        $posisi = 0;

        $this->model->find($surat->id)->update(['need_action' => $posisi]);

        $notification = new Notification;
        $notification->user_id = $surat->pegawai_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.surat-keluar.show',$histori->surat_id);
        $notification->deskripsi = "Surat Ditolak oleh ".$histori->employee->nama." (".$histori->employee->jabatan.")";
        $notification->save();

        return response()->json(['success' => 1]);

        // return redirect()->route('pegawai.surat-keluar.index')->with(['success'=>'Data berhasil disimpan']);

    }

    public function setAgendaSurat(Request $request)
    {
        $this->validate($request,[
            'file_surat' => 'required'
        ]);
        // return $request->no_agenda;
        $surat = SuratKeluar::find($request->id);
        $surat->no_agenda = $request->no_agenda;
        $surat->save();

        if(!empty($request->file('file_surat')))
        {
            $uploadedFile = $request->file('file_surat');
            $path = $uploadedFile->store('public/surat_keluar');
            $surat->file_surat_fix_url = $path;
            $surat->save();
        }

        HistoriSuratKeluar::create([
            'user_id' => auth()->user()->employee->id,
            'surat_id' => $request->id,
            'posisi' => 0,
            'status' => 3
        ]);

        return redirect()->route('pegawai.surat-keluar.index')->with(['success'=>'Surat Berhasil diagendakan']);
    }

    public function arsip(Request $request)
    {
        $arsip = new ArsipSurat;
        $arsip->surat_id = $request->id;
        $arsip->no_arsip = $request->no_arsip;
        $arsip->jenis_surat = "Surat Keluar";
        $arsip->tipe_arsip = $request->tipe_arsip;
        $arsip->save();
        HistoriSuratKeluar::create([
            'user_id' => auth()->user()->employee->id,
            'surat_id' => $request->id,
            'posisi' => 0,
            'status' => 4
        ]);
        return redirect()->route('pegawai.surat-keluar.index')->with(['success'=>'Surat telah di arsipkan']);
    }
}
