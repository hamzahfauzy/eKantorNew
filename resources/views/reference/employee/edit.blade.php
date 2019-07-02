@extends('bsbmtemplate.admin-template')
@section('kepegawaian-active','active')
@section('pegawai-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Pegawai
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Edit Data Pegawai</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('reference.employee.update')}}">
                            	@csrf
                            	<input type="hidden" name="_method" value="PUT">
                            	<input type="hidden" name="id" value="{{$pegawai->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="NIP" required value="{{old('NIP') ? old('NIP') : $pegawai->NIP}}">
                                        <label class="form-label">NIP</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama" required value="{{old('nama') ? old('nama') : $pegawai->nama }}">
                                        <label class="form-label">Nama</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="jabatan" required value="{{old('jabatan') ? old('jabatan') : $pegawai->jabatan }}">
                                        <label class="form-label">Jabatan</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="golongan_id" required="">
                                        <option value="">Pilih Golongan</option>
                                        {{'',$old_golongan = old('golongan_id') ? old('golongan_id') : $pegawai->golongan_id }}
                                        @foreach($golongan as $gol)
                                        <option value="{{$gol->id}}" {{$old_golongan == $gol->id ? 'selected=""' : '' }}>{{$gol->nama}} - {{$gol->pangkat}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="eselon_id" required="">
                                        <option value="">Pilih Eselon</option>
                                        {{'',$old_eselon = old('eselon_id') ? old('eselon_id') : $pegawai->eselon_id }}
                                        @foreach($eselon as $es)
                                        <option value="{{$es->id}}" {{$old_eselon == $es->id ? 'selected=""' : '' }}>{{$es->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <h2 class="card-inside-title">Account Information</h2>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" class="form-control" name="email" required value="{{old('email') ? old('email') : $pegawai->user->email}}">
                                        <label class="form-label">E-Mail</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <label>*kosongkan password jika tidak diganti</label>
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password">
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="level" required="">
                                        <option value="">Pilih Level</option>
                                        {{'',$old_level = old('level') ? old('level') : $pegawai->user->level}}
                                        @foreach(['admin','pegawai'] as $level)
                                        <option value="{{$level}}" {{$old_level == $level ? 'selected=""' : '' }}>{{$level}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('script')
<!-- Select Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
@endsection