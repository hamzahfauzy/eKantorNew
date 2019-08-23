<?php

namespace App\Http\Controllers\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Reference\Program;

class ProgramController extends Controller
{

    public function __construct()
    {
        $this->model = new Program;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reference.program.index',[
            'program' => $this->model->get()
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
        return view('reference.program.create');
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
            'kd_program' => 'required|unique:programs',
            'nama' => 'required|unique:programs',
        ]);

        $this->model->create([
            'kd_program' => $request->kd_program,
            'nama' => $request->nama,
        ]);

        return redirect()->route('reference.program.index')->with(['success'=>'Data berhasil disimpan']);
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
    public function edit(Program $program)
    {
        //
        return view('reference.program.edit')->with('program',$program);
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
            'kd_program' => 'required|unique:programs,kd_program,'.$request->id.',id,kd_program,'.$request->kd_program,
            'nama' => 'required|unique:programs,nama,'.$request->id.',id,nama,'.$request->nama,
        ]);

        $this->model->find($request->id)->update([
            'kd_program' => $request->kd_program,
            'nama' => $request->nama,
        ]);

        return redirect()->route('reference.program.index')->with(['success'=>'Data berhasil diupdate']);;
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
        return redirect()->route('reference.program.index')->with(['success'=>'Data berhasil dihapus']);;
    }
}
