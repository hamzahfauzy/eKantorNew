<?php

namespace App\Http\Controllers\SpecialRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Surat\SuratMasuk;

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
        return view('special-role.surat-masuk.index',[
            'surat' => $this->model->where('pegawai_id',auth()->user()->employee->id)->orderby('id','desc')->get()
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

        $this->model->create([
            'no_agenda' => $request->no_agenda,
            'no_surat' => $request->no_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_terima' => $request->tanggal_terima,
            'sumber_surat' => $request->sumber_surat,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'file_url_surat' => $path,
            'pegawai_id' => auth()->user()->employee->id,
        ]);

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
}
