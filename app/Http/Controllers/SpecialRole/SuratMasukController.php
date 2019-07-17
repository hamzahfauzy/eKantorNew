<?php

namespace App\Http\Controllers\SpecialRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Reference\Employee;
use App\Model\Surat\{SuratMasuk,Disposisi,ArsipSurat};
use App\Model\Surat\HistoriSuratMasuk;
use App\Model\{Notification, Setting};

class SuratMasukController extends Controller
{

    public function __construct()
    {
        $this->model = new SuratMasuk;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $surat = $this->model->where('pegawai_id',auth()->user()->employee->id)->orderby('id','desc')->get();
        if(auth()->user()->employee->kepala_group_special_role())
            $surat = $this->model->orderby('id','desc')->get();
        return view('special-role.surat-masuk.index',[
            'surat' => $surat
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
        return view('special-role.surat-masuk.create');
    }

    public function teruskan(Request $request)
    {
        $surat = $this->model->find($request->id);
        $this->model->find($request->id)->update([
            'status_teruskan' => 1
        ]);

        HistoriSuratMasuk::create([
            'surat_masuk_id' => $request->id,
            'status' => 'Surat diteruskan oleh Sekretaris ke Pimpinan'
        ]);

        $notification = new Notification;
        $notification->user_id = Setting::find(1)->pimpinan_id;
        $notification->status = 0;
        $notification->url_to = route('detail-surat-masuk',$surat->id);
        $notification->deskripsi = "Surat Masuk - ".$surat->sifat_surat.' - '.$surat->sumber_surat;
        $notification->save();

        return redirect()->route('pegawai.surat-masuk.index')->with(['success'=>'Surat sudah diteruskan']);
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
            'no_agenda' => 'required|unique:surat_masuks',
            'no_surat' => 'required|unique:surat_masuks',
            'tanggal_surat' => 'required',
            'tanggal_terima' => 'required',
            'sumber_surat' => 'required',
            'sifat_surat' => 'required',
            'perihal' => 'required',
            'keterangan' => 'required',
            'file_surat' => 'required',
        ]);

        $path = "";
        if(!empty($request->file('file_surat')))
        {
            $uploadedFile = $request->file('file_surat');
            $path = $uploadedFile->store('public/surat_masuk');
        }

        $surat = $this->model->create([
            'no_agenda' => $request->no_agenda,
            'no_surat' => $request->no_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_terima' => $request->tanggal_terima,
            'sumber_surat' => $request->sumber_surat,
            'sifat_surat' => $request->sifat_surat,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'file_url_surat' => $path,
            'pegawai_id' => auth()->user()->employee->id,
        ]);

        $histori = new HistoriSuratMasuk;
        $histori->create([
            'surat_masuk_id' => $surat->id,
            'status' => 'Surat Masuk'
        ]);

        $employees = Employee::get();
        $employee_id = 0;
        foreach($employees as $employee)
        {
            if($employee->kepala_group_special_role())
            {
                $employee_id = $employee->id;
            }
        }

        if($employee_id)
        {
            $notification = new Notification;
            $notification->user_id = $employee_id;
            $notification->status = 0;
            $notification->url_to = route('detail-surat-masuk',$surat->id);
            $notification->deskripsi = "Surat Masuk - ".$request->sifat_surat.' - '.$request->sumber_surat;
            $notification->save();
        }

        return redirect()->route('pegawai.surat-masuk.index')->with(['success'=>'Data berhasil disimpan']);
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
    public function edit(SuratMasuk $surat)
    {
        //
        return view('special-role.surat-masuk.edit',[
            'surat' => $surat
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
            'no_agenda' => 'required|unique:surat_masuks,no_agenda,'.$request->id.',id,no_agenda,'.$request->no_agenda,
            'no_surat' => 'required|unique:surat_masuks,no_surat,'.$request->id.',id,no_surat,'.$request->no_surat,
            'tanggal_surat' => 'required',
            'tanggal_terima' => 'required',
            'sumber_surat' => 'required',
            'sifat_surat' => 'required',
            'perihal' => 'required',
            'keterangan' => 'required',
        ]);

        $path = "";
        if(!empty($request->file('file_surat')))
        {
            $uploadedFile = $request->file('file_surat');
            $path = $uploadedFile->store('public/surat_masuk');
            $this->model->find($request->id)->update([
                'file_url_surat' => $path,
            ]);
        }

        $this->model->find($request->id)->update([
            'no_agenda' => $request->no_agenda,
            'no_surat' => $request->no_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_terima' => $request->tanggal_terima,
            'sumber_surat' => $request->sumber_surat,
            'sifat_surat' => $request->sifat_surat,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'pegawai_id' => auth()->user()->employee->id,
        ]);

        return redirect()->route('pegawai.surat-masuk.index')->with(['success'=>'Data berhasil diupdate']);
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
        return redirect()->route('pegawai.surat-masuk.index')->with(['success'=>'Data berhasil dihapus']);

    }

    public function setDisposisi(Request $request, $id)
    {
        foreach($request->pegawai as $pegawai)
        {
            $disposisi = new Disposisi;
            $disposisi->pegawai_id = $pegawai;
            $disposisi->surat_masuk_id = $id;
            $disposisi->catatan = $request->catatan;
            $disposisi->save();

            HistoriSuratMasuk::create([
                'surat_masuk_id' => $id,
                'status' => 'Surat sudah di disposisikan oleh Pimpinan'
            ]);

            $surat = SuratMasuk::find($id);

            $notification = new Notification;
            $notification->user_id = $pegawai;
            $notification->status = 0;
            $notification->url_to = route('detail-surat-masuk',$surat->id);
            $notification->deskripsi = "Dispoisisi - ".$surat->sifat_surat.' - '.$surat->sumber_surat;
            $notification->save();
        }

        return redirect()->route('detail-surat-masuk',$id)->with(['success'=>'Surat telah di Disposisikan']);
    }

    public function print(SuratMasuk $surat)
    {
        $setting = Setting::find(1);
        return view('special-role.surat-masuk.print')
                ->with('surat',$surat)
                ->with('setting',$setting);
    }

    public function arsip(Request $request)
    {
        $arsip = new ArsipSurat;
        $arsip->surat_id = $request->id;
        $arsip->no_arsip = $request->no_arsip;
        $arsip->jenis_surat = "Surat Masuk";
        $arsip->save();
        return redirect()->route('pegawai.surat-masuk.index')->with(['success'=>'Surat telah di arsipkan']);
    }
}
