<?php

namespace App\Http\Controllers\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Reference\{Employee,Golongan,Eselon};
use App\User;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->model = new Employee;
        $this->golongan = Golongan::get();
        $this->eselon = Eselon::get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reference.employee.index')->with('employees',$this->model->orderby('nama')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('reference.employee.create',[
            'golongan' => $this->golongan,
            'eselon' => $this->eselon,
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
            'NIP' => 'required|unique:employees',
            'nama' => 'required',
            'jabatan' => 'required',
            'golongan_id' => 'required',
            'eselon_id' => 'required',
            'email' => 'required:unique:users',
            'password' => 'required',
            'level' => 'required',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => $request->level,
        ]);

        $employee = $this->model->create([
            'NIP' => $request->NIP,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'golongan_id' => $request->golongan_id,
            'eselon_id' => $request->eselon_id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('reference.employee.index')->with(['success'=>'Data berhasil disimpan']);;
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
    public function edit(Employee $employee)
    {
        //
        return view('reference.employee.edit',[
            'pegawai' => $employee,
            'golongan' => $this->golongan,
            'eselon' => $this->eselon,
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
        $employee = $this->model->find($request->id);
        //
        $this->validate($request,[
            'NIP' => 'required|unique:employees,NIP,'.$request->id.',id,NIP,'.$request->NIP,
            'nama' => 'required',
            'jabatan' => 'required',
            'golongan_id' => 'required',
            'eselon_id' => 'required',
            'email' => 'required:unique:users,email,'.$employee->user_id.',id,email,'.$request->email,
            'level' => 'required',
        ]);

        $user = User::find($employee->user_id)->update([
            'name' => $request->nama,
            'email' => $request->email,
            'level' => $request->level,
        ]);

        if(!empty($request->password))
        {
            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        $employee->update([
            'NIP' => $request->NIP,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'golongan_id' => $request->golongan_id,
            'eselon_id' => $request->eselon_id,
        ]);

        return redirect()->route('reference.employee.index')->with(['success'=>'Data berhasil diupdate']);;
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
        return redirect()->route('reference.employee.index')->with(['success'=>'Data berhasil dihapus']);;
    }
}
