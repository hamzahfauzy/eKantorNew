@extends('bsbmtemplate.admin-template')
@section('spt-sppd-active','active')
@section('spt-active','active')
@section('content')
<?php $status = ['Sent','Accepted','Declined']; $bg = ["","bg-teal","bg-pink"] ?>
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data SPT
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                List Data SPT
                            </h2>
                            <div class="pull-right">
                                <a href="{{route('pegawai.spt.create')}}" class="btn btn-primary waves-effect">
                                    <i class="material-icons">add</i> 
                                    <span>TAMBAH DATA</span>
                                </a>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-rekapitulasi" class="btn btn-warning waves-effect">
                                    <i class="material-icons">print</i> 
                                    <span>CETAK REKAPITULASI</span>
                                </a>
                                <div class="modal fade" id="modal-rekapitulasi" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="defaultModalLabel">Cetak Rekapitulasi SPT</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="box">
                                                <form action="{{route('pegawai.spt.rekapitulasi')}}" target="_blank">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <label>Tanggal Awal</label>
                                                        <input type="text" class="datepicker from form-control" name="tanggal_awal" placeholder="Tanggal Awal" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <label>Tanggal Akhir</label>
                                                        <input type="text" class="datepicker to form-control" name="tanggal_akhir" placeholder="Tanggal Akhir" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <label>Tahun Anggaran</label>
                                                        <input type="text" class="form-control" name="tahun_anggaran" placeholder="Tahun Anggaran" required="">
                                                    </div>
                                                </div>
                                                <button class="btn btn-warning"><i class="material-icons">print</i> CETAK REKAPITULASI</button>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        	<div class="clearfix"></div>
                        </div>
                        <div class="body">
                        	@if ($message = Session::get('success'))
				              <div class="alert alert-success alert-block">
				                <button type="button" class="close" data-dismiss="alert">×</button> 
				                  <strong>{{ $message }}</strong>
				              </div>
				              <p></p>
				            @endif
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#own_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">email</i> SPT Anda
                                    </a>
                                </li>
                                @if(!auth()->user()->employee->staffGroup)
                                <li role="presentation">
                                    <a href="#staff_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">email</i> SPT Staff
                                    </a>
                                </li>
                                @endif

                                @if(auth()->user()->employee->inSpecialRole())
                                <li role="presentation">
                                    <a href="#staff_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">email</i> SPT Staff
                                    </a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="own_with_icon_title">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="20%">No SPT</th>
                                                    <th>Maksud</th>
                                                    <th>Tujuan</th>
                                                    <th>Tanggal</th>
                                                    <th>Pegawai</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="20%">No SPT</th>
                                                    <th>Maksud</th>
                                                    <th>Tujuan</th>
                                                    <th>Tanggal</th>
                                                    <th>Pegawai</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                {{'',$no=1}}
                                                @foreach($spt as $model)
                                                <?php $maksud_tujuan = explode("\n",$model->maksud_tujuan);?>
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>
                                                    {!! $model->no_spt ? $model->no_spt : "<i>Belum ada nomor</i>" !!}<br>
                                                    {{$model->tanggal->formatLocalized("%d %B %Y")}}<br>
                                                    @if($model->arsip_pegawai)
                                                        No. Arsip : {{$model->arsip_pegawai->no_arsip}}<br>
                                                    @else
                                                        @if($model->need_action == -1)
                                                        <a href="javascript:void(0)" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#modalArsip{{$model->id}}">Arsipkan Surat</a><br>
                                                        <div class="modal fade" id="modalArsip{{$model->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Arsip Surat Keluar</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="form_validation" method="POST" action="{{route('pegawai.spt.arsip')}}">
                                                                            {{csrf_field()}}
                                                                            <input type="hidden" name="id" value="{{$model->id}}">
                                                                            <input type="hidden" name="tipe_arsip" value="arsip pegawai">
                                                                            <div class="form-group form-float">
                                                                                <label>No. Arsip</label>
                                                                                <div class="form-line">
                                                                                    <input type="text" class="form-control" name="no_arsip" required>
                                                                                    <label class="form-label">No Arsip</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-float">
                                                                                <label>Catatan</label>
                                                                                <div class="form-line">
                                                                                    <textarea class="form-control" name="catatan" required></textarea>
                                                                                    <label class="form-label">Catatan</label>
                                                                                </div>
                                                                            </div>
                                                                            <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif
                                                    
                                                    @if($model->lastHistori)
                                                        <span class="badge {{$bg[$model->lastHistori->status]}}">{{$status[$model->lastHistori->status]}}</span>
                                                    @endif
                                                    </td>
                                                    <td>
                                                    {{$maksud_tujuan[0]}}
                                                    <br>
                                                    <span class="label label-default">{{$model->lama_waktu}} Hari</span>
                                                    </td>
                                                    <td>
                                                    {{$model->tempat_tujuan}}
                                                    </td>
                                                    <td>
                                                    <span class="label label-default">Terhitung Tanggal :</span><br>
                                                    {{$model->tanggal_awal->formatLocalized("%d %B %Y")}} <br><br> 
                                                    <span class="label label-default">Sampai Tanggal :</span><br>
                                                    {{$model->tanggal_akhir->formatLocalized("%d %B %Y")}}
                                                    </td>
                                                    <td>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#defaultModal{{$model->id}}"class="label label-primary">Lihat Pegawai</a>
                                                        <div class="modal fade" id="defaultModal{{$model->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Pegawai Pada No SPT : {{$model->no_spt}}</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                        @foreach($model->employees()->orderby('no_urut','asc')->get() as $key => $employee)
                                                                        <tr>
                                                                            <td rowspan="5">{{++$key}}</td>
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
                                                                            <td>{{$employee->employee->golongan->nama}} ({{$employee->employee->golongan->pangkat}})</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Jabatan</td>
                                                                            <td>:</td>
                                                                            <td>{{$employee->employee->jabatan}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Urutan</td>
                                                                            <td>:</td>
                                                                            <td>
                                                                            <div class="form-inline">
                                                                            @if($model->employee_id == auth()->user()->employee->id)
                                                                            <input type="number" class="form-control" name="urutan_{{$employee->id}}" value="{{$employee->no_urut}}">
                                                                            <button class="btn btn-primary" onclick="simpanUrutan({{$employee->id}})">Simpan</button>
                                                                            @else
                                                                            {{$employee->no_urut}}
                                                                            @endif
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                    <a href="{{route('pegawai.spt.doupdate')}}" class="btn btn-primary waves-effect" onclick="event.preventDefault();updateAlert({{$model->id}})">
                                                                        <i class="material-icons">create</i>
                                                                        Update
                                                                    </a>

                                                                    <form id="form-update-{{$model->id}}" style="display: none;" method="post" action="{{route('pegawai.spt.doupdate')}}">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" name="_method" value="PUT">
                                                                        <input type="hidden" name="id" value="{{$model->id}}">
                                                                    </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{route('pegawai.spt.cetak',$model->id)}}" class="btn btn-secondary waves-effect" title="Lihat SPT">
                                                            <i class="material-icons">visibility</i>
                                                        </a>

                                                        @if($model->employee_id == auth()->user()->employee->id)
                                                        <a href="{{route('pegawai.spt.edit',$model->id)}}" class="btn btn-warning waves-effect" title="Edit SPT">
                                                            <i class="material-icons">create</i>
                                                        </a>

                                                        <a href="{{route('pegawai.spt.delete')}}" class="btn btn-danger waves-effect" title="Hapus SPT" onclick="event.preventDefault();deleteAlert({{$model->id}})">
                                                            <i class="material-icons">delete</i>
                                                        </a>

                                                        <form id="form-delete-{{$model->id}}" style="display: none;" method="post" action="{{route('pegawai.spt.delete')}}">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="id" value="{{$model->id}}">
                                                        </form>
                                                        @endif
                                                        <p></p>
                                                        <a href="javascript:void(0)" class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-histori-{{$model->id}}" style="cursor:pointer;">Lihat Histori</a>
                                                        <div class="modal fade" id="modal-histori-{{$model->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Histori SPT</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="box">
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    @foreach($model->historis()->orderby('id','desc')->get() as $histori)
                                                                                    <div class="col-12">
                                                                                        <label>{{$histori->created_at->format('j F Y H:i:s')}}</label><br>
                                                                                        <p>{{$status[$histori->status].' '.$histori->employee->nama}} ({{$histori->employee->jabatan}})</p>
                                                                                    </div>
                                                                                    @endforeach

                                                                                    <div class="col-12">
                                                                                        <label>{{$model->created_at->format('j F Y H:i:s')}}</label><br>
                                                                                        <p>SPT Dibuat oleh {{$model->employee->nama}} ({{$model->employee->jabatan}})</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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

                                @if(!auth()->user()->employee->staffGroup)
                                <?php $status = ['Received','Accepted','Declined']; $bg = ["","bg-teal","bg-pink"] ?>
                                <div role="tabpanel" class="tab-pane fade" id="staff_with_icon_title">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="20%">No SPT</th>
                                                    <th>Maksud</th>
                                                    <th>Tujuan</th>
                                                    <th>Tanggal</th>
                                                    <th>Pegawai</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="20%">No SPT</th>
                                                    <th>Maksud</th>
                                                    <th>Tujuan</th>
                                                    <th>Tanggal</th>
                                                    <th>Pegawai</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                {{'',$no=1}}
                                                <?php $spt_id = [] ?>
                                                @foreach($spt_staffs as $histori)
                                                <?php $model = $histori->spt; ?>
                                                    @if(in_array($histori->spt_id,$spt_id))
                                                        @continue;
                                                    @endif
                                                <?php $spt_id[] = $histori->spt_id; ?>
                                                <?php $maksud_tujuan = explode("\n",$model->maksud_tujuan);?>
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>
                                                    {!! $model->no_spt ? $model->no_spt : "<i>Belum ada nomor</i>" !!}<br>
                                                    {{$model->tanggal->formatLocalized("%d %B %Y")}}<br>
                                                    @if($model->hasAction($histori->user_id))
                                                        <span class="badge {{$bg[$model->hasAction($histori->user_id)->status]}}">{{$status[$model->hasAction($histori->user_id)->status]}}</span>
                                                    @endif
                                                    </td>
                                                    <td>
                                                    {{$maksud_tujuan[0]}}
                                                    <br>
                                                    <span class="label label-default">{{$model->lama_waktu}} Hari</span>
                                                    </td>
                                                    <td>
                                                    {{$model->tempat_tujuan}}
                                                    </td>
                                                    <td>
                                                    <span class="label label-default">Terhitung Tanggal :</span><br>
                                                    {{$model->tanggal_awal->formatLocalized("%d %B %Y")}} <br><br> 
                                                    <span class="label label-default">Sampai Tanggal :</span><br>
                                                    {{$model->tanggal_akhir->formatLocalized("%d %B %Y")}}
                                                    </td>
                                                    <td>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#spt_staff{{$model->id}}" class="label label-primary">Lihat Pegawai</a>
                                                        <div class="modal fade" id="spt_staff{{$model->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Pegawai Pada No SPT : {{$model->no_spt}}</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                        @foreach($model->employees()->orderby('no_urut','asc')->get() as $key => $employee)
                                                                        <tr>
                                                                            <td rowspan="5">{{++$key}}</td>
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
                                                                            <td>{{$employee->employee->golongan->nama}} ({{$employee->employee->golongan->pangkat}})</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Jabatan</td>
                                                                            <td>:</td>
                                                                            <td>{{$employee->employee->jabatan}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Urutan</td>
                                                                            <td>:</td>
                                                                            <td>
                                                                            <div class="form-inline">
                                                                            {{$employee->no_urut}}
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{route('pegawai.spt.cetak',$model->id)}}" target="_blank" class="btn btn-info waves-effect">
                                                            <i class="material-icons">visibility</i>
                                                            
                                                        </a>

                                                        @if($model->need_action == $model->lastHistori->posisi)
                                                        <a href="{{route('pegawai.spt.accept')}}" class="btn btn-success waves-effect" onclick="event.preventDefault();acceptAlert({{$histori->id}})">
                                                            <i class="material-icons">done</i>
                                                            
                                                        </a>

                                                        <a href="{{route('pegawai.spt.decline')}}" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#defaultModal{{$histori->id}}">
                                                            <i class="material-icons">clear</i>
                                                            
                                                        </a>

                                                        <form id="form-acc-{{$histori->id}}" style="display: none;" method="post" action="{{route('pegawai.spt.accept')}}">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="id" value="{{$histori->id}}">
                                                        </form>

                                                        <div class="modal fade" id="defaultModal{{$histori->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Tolak SPT</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="form_validation" method="POST" action="{{route('pegawai.spt.decline')}}">
                                                                            {{csrf_field()}}
                                                                            <input type="hidden" name="id" value="{{$histori->id}}">
                                                                            <div class="form-group form-float">
                                                                                <label>Catatan</label>
                                                                                <div class="form-line">
                                                                                    <textarea class="form-control" name="catatan" required></textarea>
                                                                                    <label class="form-label">Catatan</label>
                                                                                </div>
                                                                            </div>
                                                                            <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        
                                                        <p></p>
                                                        <a href="javascript:void(0)" class="btn btn-block btn-success" data-toggle="modal" data-target="#default{{$model->id}}">Lihat Histori</a>
                                                        <div class="modal fade" id="default{{$model->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Histori SPT</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="box">
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    @foreach($model->historis()->orderby('id','desc')->get() as $histori)
                                                                                    <div class="col-12">
                                                                                        <label>{{$histori->created_at->format('j F Y H:i:s')}}</label><br>
                                                                                        <p>{{$status[$histori->status].' '.$histori->employee->nama}} ({{$histori->employee->jabatan}})</p>
                                                                                    </div>
                                                                                    @endforeach

                                                                                    <div class="col-12">
                                                                                        <label>{{$model->created_at->format('j F Y H:i:s')}}</label><br>
                                                                                        <p>SPT Dibuat oleh {{$model->employee->nama}} ({{$model->employee->jabatan}})</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                                @endif

                                @if(auth()->user()->employee->inSpecialRole())
                                <?php $status = ['Received','Accepted','Declined']; $bg = ["","bg-teal","bg-pink"] ?>
                                <div role="tabpanel" class="tab-pane fade" id="staff_with_icon_title">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="20%">No SPT</th>
                                                    <th>Maksud</th>
                                                    <th>Tujuan</th>
                                                    <th>Tanggal</th>
                                                    <th>Pegawai</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="20%">No SPT</th>
                                                    <th>Maksud</th>
                                                    <th>Tujuan</th>
                                                    <th>Tanggal</th>
                                                    <th>Pegawai</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                {{'',$no=1}}
                                                <?php $spt_id = [] ?>
                                                @foreach($spt_staffs as $histori)
                                                <?php $model = $histori->spt; ?>
                                                    @if(in_array($histori->spt_id,$spt_id))
                                                        @continue;
                                                    @endif
                                                <?php $spt_id[] = $histori->spt_id; ?>
                                                <?php $maksud_tujuan = explode("\n",$model->maksud_tujuan);?>
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>
                                                    {!! $model->no_spt ? $model->no_spt : "<i>Belum ada nomor</i>" !!}<br>
                                                    {{$model->tanggal->formatLocalized("%d %B %Y")}}<br>
                                                    @if($model->hasAction($histori->user_id))
                                                        <span class="badge {{$bg[$model->hasAction($histori->user_id)->status]}}">{{$status[$model->hasAction($histori->user_id)->status]}}</span>
                                                    @endif
                                                    </td>
                                                    <td>
                                                    {{$maksud_tujuan[0]}}
                                                    <br>
                                                    <span class="label label-default">{{$model->lama_waktu}} Hari</span>
                                                    </td>
                                                    <td>
                                                    {{$model->tempat_tujuan}}
                                                    </td>
                                                    <td>
                                                    <span class="label label-default">Terhitung Tanggal :</span><br>
                                                    {{$model->tanggal_awal->formatLocalized("%d %B %Y")}} <br><br> 
                                                    <span class="label label-default">Sampai Tanggal :</span><br>
                                                    {{$model->tanggal_akhir->formatLocalized("%d %B %Y")}}
                                                    </td>
                                                    <td>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#spt_staff{{$model->id}}"class="label label-primary">Lihat Pegawai</a>
                                                        <div class="modal fade" id="spt_staff{{$model->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Pegawai Pada No SPT : {{$model->no_spt}}</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table">
                                                                        @foreach($model->employees()->orderby('no_urut','asc')->get() as $key => $employee)
                                                                        <tr>
                                                                            <td rowspan="5">{{++$key}}</td>
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
                                                                            <td>{{$employee->employee->golongan->nama}} ({{$employee->employee->golongan->pangkat}})</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Jabatan</td>
                                                                            <td>:</td>
                                                                            <td>{{$employee->employee->jabatan}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Urutan</td>
                                                                            <td>:</td>
                                                                            <td>
                                                                            <div class="form-inline">
                                                                            {{$employee->no_urut}}
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{route('pegawai.surat-keluar.show',$model->id)}}" target="_blank" class="btn btn-info waves-effect">
                                                            <i class="material-icons">visibility</i>
                                                            
                                                        </a>
                                                        <p></p>
                                                        <a href="javascript:void(0)" class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-his-{{$model->id}}">Lihat Histori</a>
                                                        <div class="modal fade" id="modal-his-{{$model->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Histori SPT</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="box">
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    @foreach($model->historis()->orderby('id','desc')->get() as $histori)
                                                                                    <div class="col-12">
                                                                                        <label>{{$histori->created_at->format('j F Y H:i:s')}}</label><br>
                                                                                        <p>{{$status[$histori->status].' '.$histori->employee->nama}} ({{$histori->employee->jabatan}})</p>
                                                                                    </div>
                                                                                    @endforeach

                                                                                    <div class="col-12">
                                                                                        <label>{{$model->created_at->format('j F Y H:i:s')}}</label><br>
                                                                                        <p>SPT Dibuat oleh {{$model->employee->nama}} ({{$model->employee->jabatan}})</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
@endsection

@section('script')
<!-- Jquery DataTable Plugin Js -->
<script src="{{asset('template/bsbm/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

<!-- Sweet Alert Plugin Js -->
<script src="{{asset('template/bsbm/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript">
$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });
});

function deleteAlert(id)
{
	swal({
	    title: 'Apakah anda yakin akan menghapus data ini?',
	    text: "Perubahan tidak dapat dikembalikan!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    confirmButtonText: 'Ya!',
	    confirmCancelText: 'Batal!'
	},function (isConfirm) {
        if (isConfirm) {
            $("#form-delete-"+id).submit()
        }
	});
}

function updateAlert(id)
{
	swal({
	    title: 'Apakah anda yakin akan mengupdate data ini?',
	    text: "Perubahan tidak dapat dikembalikan!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    confirmButtonText: 'Ya!',
	    confirmCancelText: 'Batal!'
	},function (isConfirm) {
        if (isConfirm) {
            $("#form-update-"+id).submit()
        }
	});
}

function acceptAlert(id)
{
    swal({
        title: 'Apakah anda yakin akan menyetujui SPT ini?',
        text: "Perubahan tidak dapat dikembalikan!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        confirmCancelText: 'Batal!'
    },function (isConfirm) {
        if (isConfirm) {
            $("#form-acc-"+id).submit()
        }
    });
}


function simpanUrutan(id)
{
    var urutan = $('input[name=urutan_'+id+']').val()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url:"{{route('pegawai.spt.set-urutan')}}",
        data:{id:id,urutan:urutan},
        success:function(data){
            alert('No Urut berhasil disimpan')
        }
    });
}
</script>
<!-- Select Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
<!-- Moment Plugin Js -->
<script src="{{asset('template/bsbm/plugins/momentjs/moment.js')}}"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script type="text/javascript">
$('input.datepicker.to').bootstrapMaterialDatePicker({
    clearButton: true,
    weekStart: 1,
    time: false
});
$('input.datepicker.from').bootstrapMaterialDatePicker({
    clearButton: true,
    weekStart: 1,
    time: false
}).on('change',function(e, date){
    $('input.datepicker.to').bootstrapMaterialDatePicker('setMinDate', date);
});

</script>
@endsection