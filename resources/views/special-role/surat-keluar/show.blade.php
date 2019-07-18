@extends('bsbmtemplate.admin-template')
@section('surat-active','active')
@section('surat-keluar-active','active')
@section('content')
<?php $status = ['Surat Dikirim ke','Surat Di ACC oleh','Surat Ditolak Oleh']; $bg = ["","bg-teal","bg-pink"] ?>
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Surat Keluar
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                {{$surat->perihal}}
                            </h2>
                            <div class="pull-right">
                                <span>
                                    <i class="material-icons" style="font-size: 14px">person</i>
                                    <a href="javascript:void(0)">{{$surat->employee->nama}}</a> | {{$surat->created_at->format('j F Y')}}
                                </span>
                            </div>
                        	<div class="clearfix"></div>
                        </div>
                        <div class="body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Tanggal Surat / No Surat:</label><br>
                                        <p>{{$surat->tanggal->format('j F Y')}} | {{$surat->no_surat}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Dari:</label><br>
                                        <p>{{$surat->employee->nama}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Tujuan:</label><br>
                                        <p>{{$surat->tujuan}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Perihal:</label><br>
                                        <p>{{$surat->perihal}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Keterangan:</label><br>
                                        <p>{{$surat->keterangan}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <iframe src="{{Storage::url($surat->file_surat_url)}}" style="width: 100%;height: 500px;" frameborder="0"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                Histori
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body">
                            <div class="container-fluid">
                                <div class="row">
                                    @foreach($surat->historis()->orderby('created_at','desc')->get() as $histori)
                                    <div class="col-12">
                                        <label>{{$histori->created_at->format('j F Y H:i:s')}}</label><br>
                                        <p>{{$status[$histori->status].' '.$histori->employee->nama}}</p>
                                    </div>
                                    @endforeach

                                    <div class="col-12">
                                        <label>{{$surat->created_at->format('j F Y H:i:s')}}</label><br>
                                        <p>Surat Dibuat oleh {{$surat->employee->nama}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- #END# Basic Examples -->
        </div>

@endsection
@section('script')
<!-- Select Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
@endsection