@extends('bsbmtemplate.admin-template')
@section('home-active','active')
@section('content')
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content">
                            <div class="text">SURAT MASUK</div>
                            <div class="number count-to" data-from="0" data-to="{{$suratMasuk}}" data-speed="15" data-fresh-interval="20">{{$suratMasuk}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">help</i>
                        </div>
                        <div class="content">
                            <div class="text">SURAT KELUAR</div>
                            <div class="number count-to" data-from="0" data-to="{{$suratKeluar}}" data-speed="1000" data-fresh-interval="20">{{$suratKeluar}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="content">
                            <div class="text">SPT/SPD</div>
                            <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20">{{$spt}}/{{$sppd}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">AGENDA</div>
                            <div class="number count-to" data-from="0" data-to="{{$agenda}}" data-speed="1000" data-fresh-interval="20">{{$agenda}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
        </div>
@endsection

@section('script')
<!-- Validation Plugin Js -->
<script src="{{asset('template/bsbm/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('template/bsbm/js/pages/index.js')}}"></script>
@endsection