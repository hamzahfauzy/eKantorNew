<?php

namespace App\Http\Controllers\Pimpinan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Surat\{SuratMasuk, Disposisi};
use App\Model\Reference\Employee;
use App\Model\Setting;

class SuratController extends Controller
{
    public function __construct()
    {
        $this->model = new SuratMasuk;
        $this->disposisi = Disposisi::get();
        $this->employees = Employee::where('id','!=',Setting::find(1)->pimpinan_id)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pimpinan.surat.index',[
            'surat' => $this->model->orderby('id','desc')->get()
        ]);
    }

    public function disposisi()
    {
        //
        return view('pimpinan.surat.disposisi',[
            'disposisis' => $this->disposisi
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

    public function setDisposisi(Request $request, $id)
    {
        foreach($request->pegawai as $pegawai)
        {
            $disposisi = new Disposisi;
            $disposisi->pegawai_id = $pegawai;
            $disposisi->surat_masuk_id = $id;
            $disposisi->catatan = $request->catatan;
            $disposisi->save();
        }

        return redirect()->route('pimpinan.surat.show',$id)->with(['success'=>'Surat telah di Disposisikan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SuratMasuk $surat)
    {
        //
        return view('pimpinan.surat.show',[
            'surat' => $surat,
            'employees' => $this->employees,
        ]);
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
    public function update(Request $request, $id)
    {
        //
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
