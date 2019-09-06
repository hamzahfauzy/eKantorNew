@extends('bsbmtemplate.print-template')
@section('content')
		<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div>
                        <div class="header">
                            <h2 align="center">
                                LAPORAN PERJALANAN DINAS TAHUN ANGGARAN {{date('Y')}}
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
                                            <th>NAMA PEGAWAI / NIP / JABATAN</th>
                                            <th>SPPD</th>
                                            <th>Tanggal Berangkat / Tanggal Kembali / Tujuan</th>
                                            <th>Total Biaya (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($sppd as $model)
                                        @foreach($model->employees()->orderby('no_urut','asc')->get() as $employee)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>
                                                {{$employee->employee->nama}}
                                                <br>
                                                <b>{{$employee->employee->NIP}}</b>
                                                <br>
                                                {{$employee->employee->jabatan}}
                                            </td>
                                            <td>
                                                <b>No. SPD</b> : {{$model->no_sppd}}
                                                <br>
                                                <b>Tanggal</b> : {{$model->tanggal->formatLocalized('%d %B %Y')}}<br>
                                                <b>Lama Waktu</b> : {{$model->spt->lama_waktu}} Hari
                                            </td>
                                            <td>
                                            <span class="label label-default">
                                                {{$model->spt->tanggal_awal->formatLocalized("%d %B %Y")}} - 
                                                {{$model->spt->tanggal_akhir->formatLocalized("%d %B %Y")}}
                                            </span><br>
                                            <b>Tujuan</b> : {{$model->spt->tempat_tujuan}}<br>
                                            </td>
                                            <td>{{number_format($employee->total_biaya)}}</td>
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
<script type="text/javascript">
window.print()
</script>
@endsection