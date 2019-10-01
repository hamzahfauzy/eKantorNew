@extends('bsbmtemplate.admin-template')
@section('surat-active','active')
@section('surat-keputusan-active','active')
@section('content')
<?php $status = ['SK Dikirim ke','SK Di ACC oleh','SK Ditolak Oleh']; $bg = ["","bg-teal","bg-pink"] ?>
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Surat Keputusan
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                {{$surat->tentang}}
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
                                        <p>{{$surat->tanggal->format('j F Y')}} | {{$surat->no_sk}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Dari:</label><br>
                                        <p>{{$surat->employee->nama}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Tentang:</label><br>
                                        <p>{{$surat->tentang}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Tahun:</label><br>
                                        <p>{{$surat->tahun}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        @if(env('APP_ENV') == 'local')
                                        <iframe src="{{Storage::url($surat->file_sk_fix_url ? $surat->file_sk_fix_url : $surat->file_sk_url)}}" style="width: 100%;height: 500px;" frameborder="0"></iframe>
                                        @else
                                        <iframe src="http://docs.google.com/viewer?url={{$surat->file_sk_fix_url ? Storage::url($surat->file_sk_fix_url) : Storage::url($surat->file_sk_url)}}&embedded=true" style="width: 100%;height: 500px;" frameborder="0"></iframe>
                                        @endif
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
                                    @foreach($surat->historis()->orderby('id','desc')->get() as $histori)
                                    <div class="col-12">
                                        <label>{{$histori->created_at->format('j F Y H:i:s')}}</label><br>
                                        <p>{{$status[$histori->status].' '.$histori->employee->nama}} ({{$histori->employee->jabatan}})</p>
                                    </div>
                                    @endforeach

                                    <div class="col-12">
                                        <label>{{$surat->created_at->format('j F Y H:i:s')}}</label><br>
                                        <p>SK Dibuat oleh {{$surat->employee->nama}} ({{$surat->employee->jabatan}})</p>
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