<?php

namespace App\Http\Controllers\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Reference\{Group, SubGroup, SubGroupStaff, Employee};

class SubGroupStaffController extends Controller
{
    function __construct()
    {
        $this->model = new SubGroupStaff;
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group, SubGroup $sub)
    {
        //
        return view('reference.group.sub-group.sub-group-staff.create',[
            'group' => $group,
            'employees' => $this->employees,
            'sub' => $sub,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group, SubGroup $sub)
    {
        //
        $this->validate($request,[
            'pegawai_id' => 'required|unique:sub_group_staffs'
        ]);

        $this->model->create([
            'sub_group_id' => $sub->id,
            'pegawai_id' => $request->pegawai_id,
        ]);

        return redirect()->route('reference.group.sub.show',[$group->id,$sub->id])->with(['success'=>'Data berhasil disimpan']);
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
    public function destroy(Request $request, Group $group, SubGroup $sub)
    {
        //
        $this->model->find($request->id)->delete();
        return redirect()->route('reference.group.sub.show',[$group->id,$sub->id])->with(['success'=>'Data berhasil dihapus']);
    }
}
