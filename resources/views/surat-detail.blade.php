@extends('bsbmtemplate.admin-template')
@section('surat-active','active')
@section('surat-masuk-active','active')
@section('content')
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Surat Masuk
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
                            <div class="container clearfix">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Tanggal Terima / No Agenda:</label><br>
                                        <p>{{$surat->tanggal_terima->format('j F Y')}} | {{$surat->no_agenda}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Dari:</label><br>
                                        <p>{{$surat->sumber_surat}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Tanggal Surat / No Surat:</label><br>
                                        <p>{{$surat->tanggal_surat->format('j F Y')}} | {{$surat->no_surat}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Perihal:</label><br>
                                        <p>{{$surat->perihal}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Keterangan:</label><br>
                                        <p>{{$surat->keterangan}}</p>
                                    </div>

                                    @if(!empty($surat->disposisis) && count($surat->disposisis) > 0)
                                    <div class="col-12">
                                        <label>Di Disposisikan Ke:</label><br>
                                        <ul>
                                        @foreach($surat->disposisis as $disposisi)
                                        <li>{{$disposisi->employee->nama}} ({{$disposisi->employee->staffGroup->subGroups->nama}})</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="header">
                            <a href="{{Storage::url($surat->file_url_surat)}}" class="btn btn-success waves-effect">
                                <i class="material-icons">visibility</i>
                                <span>Lihat Surat</span>
                            </a>
                            @if(empty($surat->disposisis) || count($surat->disposisis) == 0)
                            <a href="javascript:void(0)" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#defaultModal">
                                <i class="material-icons">arrow_forward</i>
                                <span>Disposisi</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
@endsection