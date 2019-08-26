<?php

namespace App\Http\Controllers\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Reference\Transportation;

class TransportationController extends Controller
{
    public function __construct()
    {
        $this->model = new Transportation;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reference.transportasi.index',[
            'transportation' => $this->model->get()
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
        return view('reference.transportasi.create');
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
            'nama' => 'required|unique:transportations',
            'status_maskapai' => 'required|unique:transportations',
        ]);

        $this->model->create([
            'nama' => $request->nama,
            'status_maskapai' => $request->status_maskapai,
        ]);

        return redirect()->route('reference.transportasi.index')->with(['success'=>'Data berhasil disimpan']);
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
    public function edit(Transportation $transportation)
    {
        //
        return view('reference.transportasi.edit')->with('transportation',$transportation);
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
            'nama' => 'required|unique:transportations,nama,'.$request->id.',id',
            'status_maskapai' => 'required|unique:transportations,status_maskapai,'.$request->id.',id',
        ]);

        $this->model->find($request->id)->update([
            'nama' => $request->nama,
            'status_maskapai' => $request->status_maskapai,
        ]);

        return redirect()->route('reference.transportasi.index')->with(['success'=>'Data berhasil diupdate']);;
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
        return redirect()->route('reference.transportasi.index')->with(['success'=>'Data berhasil dihapus']);;
    }
}
