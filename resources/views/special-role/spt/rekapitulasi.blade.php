@extends('bsbmtemplate.print-template')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div>
                        <div class="header">
                            <h2 align="center">
                                Rekap SPT Tahun Anggaran {{$tahun_anggaran}}
                            </h2>
                            <h3 align="center">{{$setting->nama}}</h3>
                        	<div class="clearfix"></div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>No SPT</th>
                                            <th>Tujuan</th>
                                            <th>Tanggal</th>
                                            <th>Pegawai</th>
                                            <th>Maksud dan Tujuan</th>
                                            <th>Perjalanan Dinas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{'',$no=1}}
                                        @if(empty($spt) || count($spt) == 0)
                                        <tr>
                                            <td colspan="7"><i>Tidak ada data</i></td>
                                        </tr>
                                        @endif
                                        @foreach($spt as $model)
                                            <?php $maksud_tujuan = explode("\n",$model->maksud_tujuan);?>
                                            @foreach($model->employees as $employee)
                                            @if($employee->employee_id != $employee_id && $employee_id != 0)
                                                @continue
                                            @endif
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>
                                                {{$model->no_spt}}<br>
                                                {{$model->tanggal->formatLocalized("%d %B %Y")}}
                                                </td>
                                                <td>
                                                {{$model->tempat_tujuan}}
                                                <br>
                                                <span class="label label-default">{{$model->lama_waktu}} Hari</span>
                                                </td>
                                                <td>
                                                <span class="label label-default">
                                                {{$model->tanggal_awal->formatLocalized("%d %B %Y")}} - 
                                                {{$model->tanggal_akhir->formatLocalized("%d %B %Y")}}
                                                </span>
                                                </td>
                                                <td>
                                                {{$employee->employee->nama}}
                                                </td>
                                                <td>
                                                {{$maksud_tujuan[0]}}
                                                </td>
                                                <td></td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
@endsection

@section('script')
<script>
window.print()
</script>
@endsection