@extends('bsbmtemplate.admin-template')
@section('surat-active','active')
@section('surat-masuk-active','active')
@section('content')
        <div class="container-fluid">
            <div class="block-header">
                <a href="javascript:void(0)" class="btn btn-success btn-print waves-effect">
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
                            <h3 align="center">
                                {{$setting->nama}}
                            </h3>
                            <h2 align="center">
                                KARTU SURAT MASUK
                            </h2>
                        </div>
                        <div class="body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>
                                                Index
                                                <br><br><br>
                                                </td>
                                                <td>
                                                Kode
                                                <br><br><br>
                                                </td>
                                                <td>
                                                No. Urut
                                                <br><br><br>
                                                </td>
                                            </tr>
                                        </table>
                                        <label>Isi Ringkas :</label>
                                        <p>{{$surat->keterangan}}</p>
                                        <br>

                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="3">
                                                    <p>Dari :</p>
                                                    <h4>{{$surat->sumber_surat}}</h4>
                                                </td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <td>
                                                    <p>Tanggal Surat</p>
                                                    <h4>{{$surat->tanggal_surat->format('d F Y')}}</h4>
                                                </td>
                                                <td>
                                                    <p>Nomor Surat</p>
                                                    <h4>{{$surat->no_surat}}</h4>
                                                </td>
                                                <td>
                                                    <p>Lampiran</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>PENGELOLA</p>
                                                    <div class="col-12">
                                                        <ul>
                                                        @foreach($surat->disposisis as $disposisi)
                                                        <li>{{$disposisi->employee->nama}} ({{$disposisi->employee->kepala_group ? $disposisi->employee->kepala_group->nama : ($disposisi->employee->kepala_sub_group ? $disposisi->employee->kepala_sub_group->nama : ($disposisi->employee->staffGroup ? $disposisi->employee->staffGroup->subGroups->nama : ''))}})</li>
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <p>Tanggal Diteruskan</p>
                                                    <h4>{{$surat->disposisis[0]->created_at->format('d F Y')}}</h4>
                                                </td>
                                                <td align="center">
                                                    <p>Tanda Terima</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <label>Catatan :</label>
                                        <p>{{$surat->disposisis[0]->catatan}}</p>
                                        <br>
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
$(".btn-print").click(function(){
    show_print = $(".print-section").html()
    document.body.innerHTML = show_print
    window.print()
    location=location
})
</script>
@endsection