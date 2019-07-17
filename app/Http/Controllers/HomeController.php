<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\Surat\{Disposisi, SuratMasuk, HistoriSuratMasuk};
use App\Model\Reference\Employee;
use App\Model\Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function disposisi()
    {
        $disposisi = Disposisi::where('pegawai_id',auth()->user()->employee->id)->orderby('id','desc')->get();
        return view('disposisi',[
            'disposisis' => $disposisi
        ]);
    }

    public function detailSuratMasuk(SuratMasuk $surat)
    {

        // check is sekretaris
        if(auth()->user()->employee->kepala_group_special_role())
        {
            $status = 'Surat sudah dibaca oleh Sekretaris';
            $histori = HistoriSuratMasuk::where('surat_masuk_id',$surat->id)->where('status',$status)->first();
            if(!$histori)
            {
                HistoriSuratMasuk::create([
                    'status' => $status,
                    'surat_masuk_id' => $surat->id
                ]);
            }
        }

        if(auth()->user()->employee->isPimpinan())
        {
            $status = 'Surat sudah dibaca oleh Pimpinan';
            $histori = HistoriSuratMasuk::where('surat_masuk_id',$surat->id)->where('status',$status)->first();
            if(!$histori)
            {
                HistoriSuratMasuk::create([
                    'status' => $status,
                    'surat_masuk_id' => $surat->id
                ]);
            }
        }

        return view('surat-detail',[
            'surat' => $surat,
            'employees' => Employee::get()
        ]);
    }

    public function fileViewer()
    {
        $storage_url = $_GET['url'];
        $file = Storage::url($storage_url);
        $pathinfo = pathinfo($file);
        if($pathinfo['extension'] == "pdf")
        {
            return redirect($file);
        }
    }

    public function notificationRedirector(Notification $notification)
    {
        if(auth()->user()->employee->id == $notification->user_id)
        {
            $notification->status = 1;
            $notification->save();
            return redirect($notification->url_to);
        }

        return abort(404);

    }
}
