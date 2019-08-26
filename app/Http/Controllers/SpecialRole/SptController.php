<?php

namespace App\Http\Controllers\SpecialRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Surat\SptNumber;

class SptController extends Controller
{
    function __construct()
    {
        $this->model = new SptNumber;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('special-role.spt.index',[
            'spt' => $this->model->get()
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
        return view('special-role.spt.create');
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
            'no_spt' => 'required'
        ]);

        $this->model->create([
            'no_spt' => $request->no_spt
        ]);

        return redirect()->route('pegawai.spt-role.index')->with(['success'=>'Data berhasil disimpan']);
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
    public function edit(SptNumber $spt)
    {
        //
        return view('special-role.spt.edit',[
            'spt' => $spt
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
            'no_spt' => 'required'
        ]);

        $this->model->find($request->id)->update([
            'no_spt' => $request->no_spt
        ]);

        return redirect()->route('pegawai.spt-role.index')->with(['success'=>'Data berhasil diupdate']);
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
        $spt = $this->model->find($request->id);
        if($spt->list)
        {
            $list = $spt->list()->first();
            $list->no_spt = '';
            $list->save();
        }
        $spt->delete();

        return redirect()->route('pegawai.spt-role.index')->with(['success'=>'Data berhasil dihapus']);
    }
}
