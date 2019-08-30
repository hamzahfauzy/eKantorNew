<?php

namespace App\Http\Controllers\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Reference\{Program,Kegiatan,Employee};

class KegiatanController extends Controller
{
    public function __construct()
    {
        $this->model = new Kegiatan;
        $this->program = Program::get();
        $this->employees = Employee::get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reference.kegiatan.index')->with('kegiatan',$this->model->orderby('kd_kegiatan')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('reference.kegiatan.create',[
            'programs' => $this->program,
            'employees' => $this->employees
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
            'nama' => 'required|unique:kegiatans,nama,'.$request->nama.',nama,program_id,'.$request->program_id.',kd_kegiatan,'.$request->kd_kegiatan,
            'program_id' => 'required|unique:kegiatans,program_id,'.$request->nama.',nama,program_id,'.$request->program_id.',kd_kegiatan,'.$request->kd_kegiatan,
            'kd_kegiatan' => 'required|unique:kegiatans,kd_kegiatan,'.$request->nama.',nama,program_id,'.$request->program_id.',kd_kegiatan,'.$request->kd_kegiatan,
            'pagu_kegiatan' => 'required',
            'pptk_id' => 'required'
        ]);

        $this->model->create([
            'nama' => $request->nama,
            'program_id' => $request->program_id,
            'kd_kegiatan' => $request->kd_kegiatan,
            'pagu_kegiatan' => $request->pagu_kegiatan,
            'pptk_id' => $request->pptk_id
        ]);

        return redirect()->route('reference.kegiatan.index')->with(['success'=>'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Kegiatan $kegiatan)
    {
        //
        return view('reference.kegiatan.show')->with('kegiatan',$kegiatan); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Kegiatan $kegiatan)
    {
        //
        return view('reference.kegiatan.edit',[
            'programs' => $this->program,
            'model' => $kegiatan,
            'employees' => $this->employees
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
            'nama' => 'required|unique:kegiatans,nama,'.$request->id.',id,nama,'.$request->nama.',program_id,'.$request->program_id.',kd_kegiatan,'.$request->kd_kegiatan,
            'program_id' => 'required|unique:kegiatans,program_id,'.$request->id.',id,nama,'.$request->nama.',program_id,'.$request->program_id.',kd_kegiatan,'.$request->kd_kegiatan,
            'kd_kegiatan' => 'required|unique:kegiatans,kd_kegiatan,'.$request->id.',id,nama,'.$request->nama.',program_id,'.$request->program_id.',kd_kegiatan,'.$request->kd_kegiatan,
            'pagu_kegiatan' => 'required',
            'pptk_id' => 'required'
        ]);

        $this->model->find($request->id)->update([
            'nama' => $request->nama,
            'program_id' => $request->program_id,
            'kd_kegiatan' => $request->kd_kegiatan,
            'pagu_kegiatan' => $request->pagu_kegiatan,
            'pptk_id' => $request->pptk_id
        ]);

        return redirect()->route('reference.kegiatan.index')->with(['success'=>'Data berhasil diupdate']);;
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
        return redirect()->route('reference.kegiatan.index')->with(['success'=>'Data berhasil dihapus']);;
    }
}
