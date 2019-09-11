<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Agenda;

class AgendaController extends Controller
{
    //

    function __construct()
    {
        $this->model = new Agenda;
    }

    function index()
    {
        return view('agenda.index',[
            'agendas' => $this->model->where('employee_id',auth()->user()->employee->id)->get()
        ]);
    }
    
    function create()
    {
        return view('agenda.create');
    }

    function store(Request $request)
    {
        $this->validate($request,[
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
            'kegiatan' => 'required',
            'tempat' => 'required',
            'keterangan' => 'required',
        ]);

        $path = "";
        if(!empty($request->file('file_url')))
        {
            $uploadedFile = $request->file('file_url');
            $path = $uploadedFile->store('public/file_agenda');
        }

        $model = $this->model->create([
            'employee_id' => auth()->user()->employee->id,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'waktu_mulai' => $request->waktu_mulai ? $request->waktu_mulai : '',
            'waktu_selesai' => $request->waktu_selesai ? $request->waktu_selesai : '',
            'kegiatan' => $request->kegiatan,
            'tempat' => $request->tempat,
            'keterangan' => $request->keterangan,
            'file_url' => $path,
            'status' => 0
        ]);

        return redirect()->route('agenda.index')->with(['success'=>'Data berhasil disimpan']);
    }

    function edit(Agenda $agenda)
    {
        return view('agenda.edit',[
            'agenda' => $agenda
        ]);
    }

    function update(Request $request)
    {
        $this->validate($request,[
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
            'kegiatan' => 'required',
            'tempat' => 'required',
            'keterangan' => 'required',
        ]);

        $this->model->find($request->id)->update([
            'employee_id' => auth()->user()->employee->id,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'waktu_mulai' => $request->waktu_mulai ? $request->waktu_mulai : '',
            'waktu_selesai' => $request->waktu_selesai ? $request->waktu_selesai : '',
            'kegiatan' => $request->kegiatan,
            'tempat' => $request->tempat,
            'keterangan' => $request->keterangan,
            'status' => 0
        ]);

        $path = "";
        if(!empty($request->file('file_url')))
        {
            $uploadedFile = $request->file('file_url');
            $path = $uploadedFile->store('public/file_agenda');

            $this->model->find($request->id)->update([
                'file_url' => $path,
            ]);
        }

        return redirect()->route('agenda.index')->with(['success'=>'Data berhasil diupdate']);
    }

    function destroy(Request $request)
    {
        $this->model->find($request->id)->delete();
        return redirect()->route('agenda.index')->with(['success'=>'Data berhasil dihapus']);
    }
}
