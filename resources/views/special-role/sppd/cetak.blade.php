@extends('bsbmtemplate.admin-template')
@section('spt-sppd-active','active')
@section('sppd-active','active')
@section('content')
        <div class="container-fluid">
            <div class="block-header">
                <a href="javascript:void(0)" onclick="doPrint()" class="btn btn-success btn-print waves-effect">
                    <i class="material-icons">print</i>
                    <span>Print</span>
                </a>
            </div>
            <!-- Basic Examples -->
            <div class="print-section">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div style="float:left;">
                            <img src="{{Storage::url($setting->logo)}}" class="img-responsive" width="100px">
                            </div>
                            <div>
                                <h3 align="center" style="margin:0;padding:0;font-size:30px;">
                                    PEMERINTAH KABUPATEN ASAHAN
                                </h2>
                                <h3 align="center" style="margin:0;padding:0;text-transform:uppercase;font-size:20px;">
                                    {{$setting->nama}}
                                </h3>
                                <h4 align="center" style="margin:0;padding:0;">
                                    {{$setting->alamat}}
                                </h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body" style="font-size:;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <center>
                                        <h4 style="margin-bottom:0;"><u>SURAT PERJALANAN DINAS</u></h4>
                                        <span>Nomor. {{$sppd->no_sppd}}</span>
                                        <p></p>
                                        <br>
                                        </center>

                                        <table class="table table-bordered">
                                        <tr>
                                            <td>1</td>
                                            <td>Pejabat Berwenang yang Memberi Perintah</td>
                                            <td colspan="2" width="65%"><b>{{$sppd->spt->pimpinan->jabatan}}</b></td>
                                        </tr>
                                        @foreach($sppd->employees()->orderby('no_urut','asc')->get() as $key => $employee)
                                        @if($key == 0)
                                        <tr>
                                            <td>2</td>
                                            <td>Nama / NIP Pegawai yang melaksanakan Perjalanan Dinas</td>
                                            <td colspan="2">
                                            <b>{{$employee->employee->nama}}</b><br>
                                            NIP . {{$employee->employee->NIP}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3">3</td>
                                            <td>a. Pangkat dan Golongan</td>
                                            <td colspan="2">a. {{$employee->employee->golongan->nama}} ({{$employee->employee->golongan->pangkat}})</td>
                                        </tr>
                                        <tr>
                                            <td>b. Jabatan Instansi</td>
                                            <td colspan="2">b. {{$employee->employee->jabatan}}</td>
                                        </tr>
                                        <tr>
                                            <td>c. Tingkat Biaya Perjalanan Dinas</td>
                                            <td colspan="2">c. </td>
                                        </tr>
                                        @endif
                                        @endforeach 
                                        <?php $maksud_tujuan = explode("\n",$sppd->spt->maksud_tujuan);?>
                                        <tr>
                                            <td>4</td>
                                            <td>Maksud Perjalanan Dinas</td>
                                            <td colspan="2">{{$maksud_tujuan[0]}}</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Angkutan Yang Digunakan</td>
                                            <td colspan="2">{{$sppd->transportation->nama}}</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">6</td>
                                            <td>a. Tempat Berangkat</td>
                                            <td colspan="2">{{$sppd->asal}}</td>
                                        </tr>
                                        <tr>
                                            <td>b. Tempat Tujuan</td>
                                            <td colspan="2">{{$sppd->tujuan}}</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3">7</td>
                                            <td>a. Lamanya Perjalanan Dinas</td>
                                            <td colspan="2">{{$sppd->spt->lama_waktu}} Hari</td>
                                        </tr>
                                        <tr>
                                            <td>b. Tanggal Berangkat</td>
                                            <td colspan="2">{{$sppd->spt->tanggal_awal->formatLocalized('%d %B %Y')}}</td>
                                        </tr>
                                        <tr>
                                            <td>c. Tanggal Harus Kembali</td>
                                            <td colspan="2">{{$sppd->spt->tanggal_akhir->formatLocalized('%d %B %Y')}}</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="{{count($sppd->employees)}}">8</td>
                                            <td>Pengikut : Nama</td>
                                            <td>Pangkat</td>
                                            <td>Jabatan</td>
                                        </tr>
                                        @foreach($sppd->employees()->orderby('no_urut','asc')->get() as $key => $employee)
                                        <?php if($key == 0) continue; ?>
                                        <tr>
                                            <td>{{$employee->employee->nama}}</td>
                                            <td width="35%">{{$employee->employee->golongan->nama}} ({{$employee->employee->golongan->pangkat}})</td>
                                            <td>{{$employee->employee->jabatan}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>9</td>
                                            <td>
                                            Pembebanan Anggaran<br>
                                            a. Instansi<br>
                                            b. Akun<br>
                                            </td>
                                            <td colspan="2">
                                            <br>
                                            a. <br>
                                            b. <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>Keterangan Lain-lain</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        </table>

                                        <br>
                                        <table width="40%" align="right">
                                        <tr>
                                            <td>Dikeluarkan di Kisaran</td>
                                        </tr>
                                        <tr>
                                            <td>Pada Tanggal {{$sppd->tanggal->formatLocalized('%d %B %Y')}}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ strtoupper($sppd->spt->pimpinan->jabatan) }} KABUPATEN ASAHAN</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <br><br><br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>{{strtoupper($sppd->spt->pimpinan->nama)}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{$sppd->spt->pimpinan->golongan->nama}}</td>
                                        </tr>
                                        <tr>
                                            <td>NIP. {{$sppd->spt->pimpinan->NIP}}</td>
                                        </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- #END# Basic Examples -->
            </div>
        </div>
@endsection

@section('script')
<script type="text/javascript">
var old_html = document.body.innerHTML;
var show_print = ""

function doPrint()
{
    var lampiran_value = $("#lampiran").val()
    $("#jumlah_lampiran").html(lampiran_value)
    $("#lampiran").css("display","none")
    show_print = $(".print-section").html()
    document.body.innerHTML = show_print
    window.print()
    document.body.innerHTML = old_html
    $("#lampiran").val(lampiran_value)
    $('.page-loader-wrapper').hide()
}
</script>
@endsection