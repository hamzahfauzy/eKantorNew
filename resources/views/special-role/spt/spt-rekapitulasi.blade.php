@extends('bsbmtemplate.print-template')
@section('content')
		<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div>
                        <div class="header">
                            <h2 align="center">
                                Rekap SPT Tahun Anggaran {{date('Y')}}
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
                                            <th>Selama</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($spt as $model)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$model->no_spt}}</td>
                                            <td>{{$model->tempat_tujuan}}</td>
                                            <td>{{$model->lama_waktu}} Hari</td>
                                            <td>
                                            <span class="label label-default">Terhitung Tanggal :</span><br>
                                            {{$model->tanggal_awal->formatLocalized("%d %B %Y")}} <br><br> 
                                            <span class="label label-default">Sampai Tanggal :</span><br>
                                            {{$model->tanggal_akhir->formatLocalized("%d %B %Y")}}
                                            </td>
                                        </tr>
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