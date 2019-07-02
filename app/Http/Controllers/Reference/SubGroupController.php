<?php

namespace App\Http\Controllers\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Reference\{Group, SubGroup, Employee};

class SubGroupController extends Controller
{

    public function __construct()
    {
        $this->model = new SubGroup;
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        //
        return view('reference.group.sub-group.create',[
            'group' => $group,
            'employees' => $this->employee,
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
            'nama' => 'required|unique:sub_groups',
            'kepala_id' => 'required',
            'group_id' => 'required',
        ]);

        $this->model->create([
            'nama' => $request->nama,
            'kepala_id' => $request->kepala_id,
            'group_id' => $request->group_id
        ]);

        return redirect()->route('reference.group.show',$request->group_id)->with(['success'=>'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group, SubGroup $sub)
    {
        //
        return view('reference.group.sub-group.show',[
            'group' => $group,
            'sub' => $sub
        ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group, SubGroup $sub)
    {
        //
        return view('reference.group.sub-group.edit',[
            'group' => $group,
            'employees' => $this->employee,
            'model' => $sub,
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
            'nama' => 'required|unique:sub_groups,nama,'.$request->id.',id,nama,'.$request->nama,
            'kepala_id' => 'required',
            'group_id' => 'required',
        ]);

        $this->model->find($request->id)->update([
            'nama' => $request->nama,
            'kepala_id' => $request->kepala_id,
            'group_id' => $request->group_id
        ]);

        return redirect()->route('reference.group.show',$request->group_id)->with(['success'=>'Data berhasil diupdate']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Group $group)
    {
        //
        $this->model->find($request->id)->delete();
        return redirect()->route('reference.group.show',$group->id)->with(['success'=>'Data berhasil dihapus']);;
    }
}
