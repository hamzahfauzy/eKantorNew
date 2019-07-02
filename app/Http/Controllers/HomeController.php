<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Surat\{Disposisi, SuratMasuk};

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
        return view('surat-detail',[
            'surat' => $surat
        ]);
    }
}
