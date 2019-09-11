<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\Surat\{Disposisi, SuratMasuk, SuratKeluar, HistoriSuratMasuk, SptList, SppdList};
use App\Model\Reference\Employee;
use App\Model\{Notification, Agenda};

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
        $suratMasuk = SuratMasuk::count();
        $suratKeluar = SuratKeluar::count();
        $spt = SptList::count();
        $sppd = SppdList::count();
        $agenda = Agenda::count();
        return view('home',[
            "suratMasuk" => $suratMasuk,
            "suratKeluar" => $suratKeluar,
            "spt" => $spt,
            "sppd" => $sppd,
            "agenda" => $agenda
        ]);
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

    public function profil()
    {
        return view('profil');
    }

    public function agenda()
    {
        $events = [];

        $events[] = \Calendar::event(
            'Event One', //event title
            false, //full day event?
            '2019-02-11T0800', //start time (you can also use Carbon instead of DateTime)
            '2019-02-12T0800', //end time (you can also use Carbon instead of DateTime)
            0 //optionally, you can specify an event ID
        );

        $events[] = \Calendar::event(
            "Valentine's Day", //event title
            true, //full day event?
            new \DateTime('2019-02-14'), //start time (you can also use Carbon instead of DateTime)
            new 	\DateTime('2019-02-14'), //end time (you can also use Carbon instead of DateTime)
            'stringEventId' //optionally, you can specify an event ID
        );

        $calendar = \Calendar::addEvents($events) //add an array with addEvents
            ->setOptions([ //set fullcalendar options
                'firstDay' => 1,
            ])
            ->setCallbacks([
                'eventClick' => 'function(event) { alert(event.title)}',
            ]);

        return view('agenda', [
            'calendar' => $calendar
        ]);
    }
}
