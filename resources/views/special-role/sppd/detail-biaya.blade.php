@extends('bsbmtemplate.admin-template')
@section('spt-sppd-active','active')
@section('sppd-active','active')
@section('content')
<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Detail Biaya
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                Detail Biaya
                            </h2>
                            <div class="pull-right">
                                <a href="{{route('pegawai.sppd.cetak-rincian',$sppd->id)}}" class="btn btn-primary waves-effect">
                                    <i class="material-icons">print</i> 
                                    <span>CETAK RINCIAN</span>
                                </a>
                            </div>
                        	<div class="clearfix"></div>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Pengikut</th>
                                            <th>Total (Rp)</th>
                                            <th>Uang Harian (Rp)</th>
                                            <th>Transport (Rp)</th>
                                            <th>Penginapan (Rp)</th>
                                            <th>Representatif (Rp)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Pengikut</th>
                                            <th>Total (Rp)</th>
                                            <th>Uang Harian (Rp)</th>
                                            <th>Transport (Rp)</th>
                                            <th>Penginapan (Rp)</th>
                                            <th>Representatif (Rp)</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($sppd->employees()->orderby('no_urut','asc')->get() as $model)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$model->employee->nama}}</td>
                                            <td>{{number_format($model->total_biaya)}}</td>
                                            <td>{!!$model->uang_harian ? number_format($model->uang_harian)." x ".$model->lama_waktu."<br><b>Total: </b>".number_format($model->uang_harian*$model->lama_waktu) : '-'!!}</td>
                                            <td>{{$model->transport ? number_format($model->transport) : '-'}}</td>
                                            <td>{!!$model->penginapan ? number_format($model->penginapan)." x ".$model->lama_penginapan."<br><b>Total: </b>".number_format($model->penginapan*$model->lama_penginapan) : '-'!!}</td>
                                            <td>{{$model->representatif ? number_format($model->representatif) : '-'}}</td>
                                            <td>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#defaultModal{{$model->id}}" class="btn btn-warning waves-effect">
                                                    <i class="material-icons">create</i>
                                                </a>
                                                <div class="modal fade" id="defaultModal{{$model->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="defaultModalLabel">Detail Biaya</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="{{route('pegawai.sppd.set-biaya')}}">
                                                                {{csrf_field()}}
                                                                <input type="hidden" name="id" value="{{$model->id}}">
                                                                <table class="table">
                                                                <tr>
                                                                    <td>Nama</td>
                                                                    <td>:</td>
                                                                    <td>{{$model->employee->nama}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Uang Harian</td>
                                                                    <td>:</td>
                                                                    <td><input type="number" required="" class="form-control" name="uang_harian" value="{{$model->uang_harian}}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Lama Waktu (Hari)</td>
                                                                    <td>:</td>
                                                                    <td><input type="number" required="" class="form-control" name="lama_waktu" value="{{$model->lama_waktu}}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Transport</td>
                                                                    <td>:</td>
                                                                    <td><input type="number" required="" class="form-control" name="transport" value="{{$model->transport}}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Penginapan</td>
                                                                    <td>:</td>
                                                                    <td><input type="number" required="" class="form-control" name="penginapan" value="{{$model->penginapan}}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Lama Penginapan (Malam)</td>
                                                                    <td>:</td>
                                                                    <td><input type="number" required="" class="form-control" name="lama_penginapan" value="{{$model->lama_penginapan}}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Represenatif</td>
                                                                    <td>:</td>
                                                                    <td><input type="number" required="" class="form-control" name="representatif" value="{{$model->representatif}}"></td>
                                                                </tr>
                                                                </table>
                                                                <button class="btn btn-primary">Simpan</button>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
