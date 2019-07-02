<?php

namespace App\Http\Controllers\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Reference\{Group,Employee};

class GroupController extends Controller
{
    public function __construct()
    {
        $this->model = new Group;
        $this->employee = Employee::get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reference.group.index')->with('group',$this->model->orderby('nama')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('reference.group.create',[
            'employees' => $this->employee
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
            'nama' => 'required|unique:groups',
            'kepala_id' => 'required'
        ]);

        $this->model->create([
            'nama' => $request->nama,
            'kepala_id' => $request->kepala_id
        ]);

        return redirect()->route('reference.group.index')->with(['success'=>'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
        return view('reference.group.show')->with('group',$group); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
        return view('reference.group.edit',[
            'employees' => $this->employee,
            'model' => $group
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
            'nama' => 'required|unique:groups,nama,'.$request->id.',id,nama,'.$request->nama,
            'kepala_id' => 'required'
        ]);

        $this->model->find($request->id)->update([
            'nama' => $request->nama,
            'kepala_id' => $request->kepala_id
        ]);

        return redirect()->route('reference.group.index')->with(['success'=>'Data berhasil diupdate']);;
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
        return redirect()->route('reference.group.index')->with(['success'=>'Data berhasil dihapus']);;
    }
}
