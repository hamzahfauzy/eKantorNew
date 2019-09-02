@extends('bsbmtemplate.admin-template')
@section('spt-sppd-active','active')
@section('sppd-active','active')
@section('content')
<?php $maksud_tujuan = explode("\n",$sppd->spt->maksud_tujuan);?>
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
                            <div>
                                <h4 align="center" style="margin:0;padding:0;">
                                    URAIAN PERJALANAN DINAS {{$sppd->spt->wilayah->keterangan}}
                                </h4>
                                <h4 align="center" style="margin:0;padding:0;">
                                    {{$maksud_tujuan[0]}}
                                </h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body" style="font-size:;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table align="center">
                                        <tr>
                                            <td width="50%"><b>SPD NOMOR</b></td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td>{{$sppd->no_sppd}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>TANGGAL</b></td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td>{{$sppd->tanggal->formatLocalized('%d %B %Y')}}</td>
                                        </tr>
                                        </table>
                                        <br><br>
                                        <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="text-align:center">NAMA</th>
                                            <th style="text-align:center" colspan="2">BANYAKNYA</th>
                                            <th style="text-align:center">KETERANGAN</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sppd->employees()->orderby('no_urut','asc')->get() as $model)
                                        <?php if(empty($model->uang_harian)) continue; ?>
                                        <tr>
                                            <td><b>{{$model->employee->nama}}</b></td>
                                            <td colspan="2"></td>
                                            <td rowspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td>Uang Harian</td>
                                            <td>1 org x {{$model->lama_waktu}} Hari </td>
                                            <td>= Rp. {{number_format($model->uang_harian*$model->lama_waktu)}}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>Penginapan</td>
                                            <td>1 org x {{$model->lama_penginapan}} Malam </td>
                                            <td>= Rp. {{number_format($model->penginapan*$model->lama_penginapan)}}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>Transport {{$sppd->asal}} - {{$sppd->tujuan}} (PP)</td>
                                            <td>1 org </td>
                                            <td>= Rp. {{number_format($model->transport)}}</td>
                                            
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <td>= <b>Rp. {{number_format($model->total_biaya)}}</b></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Jumlah</td>
                                            <td><b>= Rp. {{number_format($sppd->total_biaya)}}</b></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan=4 style="text-align:center;text-transform: capitalize;font-style:italic"><b>Terbilang : {{$terbilang($sppd->total_biaya)}}</b></td>
                                        </tr>
                                        </tbody>
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