<?php

namespace App\Http\Controllers\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Reference\Golongan;

class GolonganController extends Controller
{
    public function __construct()
    {
        $this->model = new Golongan;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reference.golongan.index')->with('golongan',$this->model->orderby('nama')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('reference.golongan.create');
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
            'nama' => 'required|unique:golongans',
            'pangkat' => 'required'
        ]);

        $this->model->create([
            'nama' => $request->nama,
            'pangkat' => $request->pangkat
        ]);

        return redirect()->route('reference.golongan.index')->with(['success'=>'Data berhasil disimpan']);;
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
    public function edit(Golongan $golongan)
    {
        //
        return view('reference.golongan.edit')->with('golongan',$golongan);
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
            'nama' => 'required|unique:golongans,nama,'.$request->id.',id,nama,'.$request->nama,
            'pangkat' => 'required'
        ]);

        $this->model->find($request->id)->update([
            'nama' => $request->nama,
            'pangkat' => $request->pangkat
        ]);

        return redirect()->route('reference.golongan.index')->with(['success'=>'Data berhasil diupdate']);;
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
        return redirect()->route('reference.golongan.index')->with(['success'=>'Data berhasil dihapus']);;
    }
}
