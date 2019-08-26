<?php

namespace App\Http\Controllers\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Reference\WilayahTujuan;

class WilayahController extends Controller
{
    public function __construct()
    {
        $this->model = new WilayahTujuan;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reference.wilayah.index',[
            'wilayah' => $this->model->get()
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
        return view('reference.wilayah.create');
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
            'kode' => 'required|unique:wilayah_tujuans',
            'keterangan' => 'required|unique:wilayah_tujuans',
        ]);

        $this->model->create([
            'kode' => $request->kode,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('reference.wilayah.index')->with(['success'=>'Data berhasil disimpan']);
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
    public function edit(WilayahTujuan $wilayah)
    {
        //
        return view('reference.wilayah.edit')->with('wilayah',$wilayah);
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
            'kode' => 'required|unique:wilayah_tujuans,kode,'.$request->id.',id',
            'keterangan' => 'required|unique:wilayah_tujuans,keterangan,'.$request->id.',id',
        ]);

        $this->model->find($request->id)->update([
            'kode' => $request->kode,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('reference.wilayah.index')->with(['success'=>'Data berhasil diupdate']);;
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
        $this->model->find($request->id)->delete();
        return redirect()->route('reference.wilayah.index')->with(['success'=>'Data berhasil dihapus']);;
    }
}
