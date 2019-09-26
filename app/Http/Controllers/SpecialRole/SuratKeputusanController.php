<?php

namespace App\Http\Controllers\SpecialRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Surat\SuratKeluar;
use App\Model\Reference\SubGroup;

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
        return view('special-role.surat-keluar.index',[
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
            'no_surat' => 'required|unique:surat_masuks',
            'tanggal_surat' => 'required',
            'sub_group_id' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'keterangan' => 'required',
            'file_surat' => 'required',
        ]);

        $path = "";
        if(!empty($request->file('file_surat')))
        {
            $uploadedFile = $request->file('file_surat');
            $path = $uploadedFile->store('public/surat_keluar');
        }

        $this->model->create([
            'no_surat' => $request->no_surat,
            'tanggal' => $request->tanggal_surat,
            'sub_group_id' => $request->sub_group_id,
            'tujuan' => $request->tujuan,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'file_surat_url' => $path,
            'pegawai_id' => auth()->user()->employee->id,
        ]);

        return redirect()->route('pegawai.surat-keluar.index')->with(['success'=>'Data berhasil disimpan']);
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
            'sub_group_id' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'keterangan' => 'required',
        ]);

        $path = "";
        if(!empty($request->file('file_surat')))
        {
            $uploadedFile = $request->file('file_surat');
            $path = $uploadedFile->store('public/surat_keluar');
            $this->model->find($request->id)->update([
                'file_surat_url' => $path,
            ]);
        }

        $this->model->find($request->id)->update([
            'no_surat' => $request->no_surat,
            'tanggal' => $request->tanggal_surat,
            'sub_group_id' => $request->sub_group_id,
            'tujuan' => $request->tujuan,
            'perihal' => $request->perihal,
            'keterangan' => $request->keterangan,
            'pegawai_id' => auth()->user()->employee->id,
        ]);

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
}
