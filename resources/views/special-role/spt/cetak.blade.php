@extends('bsbmtemplate.admin-template')
@section('spt-sppd-active','active')
@section('spt-active','active')
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
                                <h3 align="center" style="margin:0;padding:0;font-size:37px;">
                                    PEMERINTAH KABUPATEN ASAHAN
                                </h2>
                                <h3 align="center" style="margin:0;padding:0;text-transform:uppercase">
                                    {{$setting->nama}}
                                </h3>
                                <h4 align="center" style="margin:0;padding:0;">
                                    {{$setting->alamat}}
                                </h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <center>
                                        <h4 style="margin-bottom:0;"><u>Surat Perintah Tugas</u></h4>
                                        <span>No. {{$spt->no_spt}}</span>
                                        <p></p>
                                        <br>
                                        </center>

                                        <p>{{$spt->maksud_tujuan}}. dengan ini:</p>
                                        <table class="table">
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>{{$spt->pimpinan->nama}}</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td>:</td>
                                            <td>{{$spt->pimpinan->jabatan}}</td>
                                        </tr>
                                        </table>

                                        <center>
                                        <h4 style="margin-bottom:0;"><u>MENUGASKAN :</u></h4>
                                        <p></p>
                                        <br>
                                        </center>
                                        <p>Kepada :</p>
                                        <table class="table">
                                        @foreach($spt->employees as $key => $employee)
                                        <tr>
                                            <td rowspan="4">{{++$key}}</td>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>{{$employee->employee->nama}}</td>
                                        </tr>
                                        <tr>
                                            <td>NIP</td>
                                            <td>:</td>
                                            <td>{{$employee->employee->NIP}}</td>
                                        </tr>
                                        <tr>
                                            <td>Pangkat/Gol. Ruang</td>
                                            <td>:</td>
                                            <td>{{$employee->employee->golongan->nama}} / {{$employee->employee->golongan->pangkat}}</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td>:</td>
                                            <td>{{$employee->employee->jabatan}}</td>
                                        </tr>
                                        @endforeach
                                        </table>

                                        <p>Untuk :</p>
                                        <table class="table">
                                        <tr>
                                            <td>1</td>
                                            <td>{{$spt->dasar1}}</td>
                                        </tr>
                                        @if($spt->dasar2 && $spt->dasar2 != '-')
                                        <tr>
                                            <td>2</td>
                                            <td>{{$spt->dasar2}}</td>
                                        </tr>
                                        @endif

                                        @if($spt->dasar3 && $spt->dasar3 != '-')
                                        <tr>
                                            <td>3</td>
                                            <td>{{$spt->dasar3}}</td>
                                        </tr>
                                        @endif
                                        </table>

                                        <p>Demikian surat tugas ini dibuat untuk dilaksanakan sebagaimana mestinya.</p>

                                        <table width="30%" align="right">
                                        <tr>
                                            <td>{{$spt->pimpinan->jabatan}}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <br><br><br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>{{$spt->pimpinan->nama}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>NIP. {{$spt->pimpinan->NIP}}</td>
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