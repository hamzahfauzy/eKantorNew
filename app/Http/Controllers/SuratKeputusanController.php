<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Surat\{SuratKeputusan,HistoriSuratKeputusan, ArsipSurat};
use App\Model\Reference\{SubGroup,Employee};
use App\Model\{Notification,Setting};

class SuratKeputusanController extends Controller
{
    public function __construct()
    {
        $this->model = new SuratKeputusan;
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
        $histori_surat = HistoriSuratKeputusan::where('user_id',auth()->user()->employee->id)->where('status',0)->orderby('id','desc')->get();
        $surat_staffs = HistoriSuratKeputusan::where('status',1)->orderby('id','desc')->get();
        return view('special-role.surat-keputusan.index',[
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
        return view('special-role.surat-keputusan.create',[
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
            'tanggal_surat' => 'required',
            'tentang' => 'required',
            'tahun' => 'required',
            'keterangan' => 'required',
            'file_surat' => 'required|mimes:pdf',
        ]);

        $uploadedFile = $request->file('file_surat');
        $path = $uploadedFile->store('public/surat_keputusan');

        $model = $this->model->create([
            'no_sk' => '',
            'tanggal' => $request->tanggal_surat,
            'tentang' => $request->tentang,
            'tahun' => $request->tahun,
            'keterangan' => $request->keterangan,
            'file_sk_fix_url' => '',
            'file_sk_url' => $path,
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

        HistoriSuratKeputusan::create([
            'user_id' => $pimpinan_id,
            'surat_id' => $model->id,
            'posisi' => $posisi,
            'status' => 0
        ]);

        $this->model->find($model->id)->update(['need_action' => $posisi]);

        $notification = new Notification;
        $notification->user_id = $pimpinan_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.surat-keputusan.show',$model->id);
        $notification->deskripsi = "Surat Keputusan - Dari ".auth()->user()->name." (".auth()->user()->employee->jabatan.")";
        $notification->save();

        return redirect()->route('pegawai.surat-keputusan.index')->with(['success'=>'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SuratKeputusan $surat)
    {
        //
        return view('special-role.surat-keputusan.show',[
            'surat' => $surat
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SuratKeputusan $surat)
    {
        //
        return view('special-role.surat-keputusan.edit',[
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
            'tanggal_surat' => 'required',
            'tentang' => 'required',
            'keterangan' => 'required',
            'tahun' => 'required',
        ]);

        $path = "";
        if(!empty($request->file('file_surat')))
        {
            $this->validate($request,[
                'file_surat' => 'required|mimes:pdf'
            ]);
            $uploadedFile = $request->file('file_surat');
            $path = $uploadedFile->store('public/surat_keputusan');
            $this->model->find($request->id)->update([
                'file_sk_url' => $path,
            ]);
        }

        $this->model->find($request->id)->update([
            'tanggal' => $request->tanggal_surat,
            'tentang' => $request->tentang,
            'tahun' => $request->tahun,
            'keterangan' => $request->keterangan,
            'file_sk_fix_url' => '',
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

        HistoriSuratKeputusan::create([
            'user_id' => $pimpinan_id,
            'surat_id' => $request->id,
            'posisi' => $posisi,
            'status' => 0
        ]);

        $this->model->find($request->id)->update(['need_action' => $posisi]);

        $notification = new Notification;
        $notification->user_id = $pimpinan_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.surat-keputusan.show',$request->id);
        $notification->deskripsi = "Update Surat Keputusan - Dari ".auth()->user()->name." (".auth()->user()->employee->jabatan.")";
        $notification->save();

        return redirect()->route('pegawai.surat-keputusan.index')->with(['success'=>'Data berhasil diupdate']);
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
        return redirect()->route('pegawai.surat-keputusan.index')->with(['success'=>'Data berhasil dihapus']);

    }

    public function accept(Request $request)
    {
        $histori = HistoriSuratKeputusan::find($request->id);
        $surat = SuratKeputusan::find($histori->surat_id);
        HistoriSuratKeputusan::create([
            'user_id' => $histori->user_id,
            'surat_id' => $histori->surat_id,
            'posisi' => $histori->posisi,
            'status' => 1,
        ]);

        $notification = new Notification;
        $notification->user_id = $surat->pegawai_id;
        $notification->status = 0;
        $notification->url_to = route('pegawai.surat-keputusan.show',$surat->id);
        $notification->deskripsi = "Surat Diterima oleh ".$histori->employee->nama." (".$histori->employee->jabatan.")";
        $notification->save();

        $pimpinan_id = 0;
        $posisi = $histori->posisi;
        if($posisi == 1)
        {
            $surat->update(['need_action' => -1]);   
            return redirect()->route('pegawai.surat-keputusan.index')->with(['success'=>'Data berhasil disimpan']);
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
            HistoriSuratKeputusan::create([
                'user_id' => $pimpinan_id,
                'surat_id' => $histori->surat_id,
                'posisi' => $posisi,
                'status' => 0
            ]);
            $this->model->find($histori->surat_id)->update(['need_action' => $posisi]);
            $notification = new Notification;
            $notification->user_id = $pimpinan_id;
            $notification->status = 0;
            $notification->url_to = route('pegawai.surat-keputusan.show',$histori->surat_id);
            $notification->deskripsi = "Surat Keluar - Dari ".$histori->suratKeputusan->employee->nama." (".$histori->suratKeputusan->employee->jabatan.")";
            $notification->save();
        }
        else
        {
            $this->model->find($histori->surat_id)->update(['need_action' => -1]);
        }

        return redirect()->route('pegawai.surat-keputusan.index')->with(['success'=>'Data berhasil disimpan']);

    }

    public function declineEditor(HistoriSuratKeputusan $histori)
    {
        $surat = SuratKeputusan::find($histori->surat_id);
        return view('special-role.surat-keputusan.decline-editor',[
            'surat' => $surat,
            'histori' => $histori
        ]);
    }

    public function declineViewer(HistoriSuratKeputusan $histori)
    {
        $surat = SuratKeputusan::find($histori->surat_id);
        return view('special-role.surat-keputusan.decline-viewer',[
            'surat' => $surat,
            'histori' => $histori
        ]);
    }

    public function decline(Request $request)
    {
        $histori = HistoriSuratKeputusan::find($request->id);
        $surat = SuratKeputusan::find($histori->surat_id);
        HistoriSuratKeputusan::create([
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
        $notification->url_to = route('pegawai.surat-keputusan.show',$histori->surat_id);
        $notification->deskripsi = "Surat Ditolak oleh ".$histori->employee->nama." (".$histori->employee->jabatan.")";
        $notification->save();

        return response()->json(['success' => 1]);

        // return redirect()->route('pegawai.surat-keputusan.index')->with(['success'=>'Data berhasil disimpan']);

    }

    public function setAgendaSurat(Request $request)
    {
        $this->validate($request,[
            'file_surat' => 'required'
        ]);
        // return $request->no_agenda;
        $surat = SuratKeputusan::find($request->id);
        $surat->no_agenda = $request->no_agenda;
        $surat->save();

        if(!empty($request->file('file_surat')))
        {
            $uploadedFile = $request->file('file_surat');
            $path = $uploadedFile->store('public/surat_keputusan');
            $surat->file_surat_fix_url = $path;
            $surat->save();
        }

        return redirect()->route('pegawai.surat-keputusan.index')->with(['success'=>'Surat Berhasil diagendakan']);
    }

    public function setNoSk(Request $request)
    {
        $this->validate($request,[
            'no_sk' => 'required'
        ]);
        // return $request->no_agenda;
        $surat = SuratKeputusan::find($request->id);
        $surat->no_sk = $request->no_sk;
        $surat->save();

        if(!empty($request->file('file_surat')))
        {
            $uploadedFile = $request->file('file_surat');
            $path = $uploadedFile->store('public/surat_keputusan');
            $surat->file_sk_fix_url = $path;
            $surat->save();
        }

        return redirect()->route('pegawai.surat-keputusan.index')->with(['success'=>'No SK Berhasil disimpan']);
    }

    public function arsip(Request $request)
    {
        $arsip = new ArsipSurat;
        $arsip->surat_id = $request->id;
        $arsip->no_arsip = $request->no_arsip;
        $arsip->jenis_surat = "Surat Keputusan";
        $arsip->tipe_arsip = $request->tipe_arsip;
        $arsip->save();
        return redirect()->route('pegawai.surat-keputusan.index')->with(['success'=>'Surat telah di arsipkan']);
    }
}
