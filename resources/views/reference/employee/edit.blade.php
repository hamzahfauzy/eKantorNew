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
                            	{{csrf_field()}}
                            	<input type="hidden" name="_method" value="PUT">
                            	<input type="hidden" name="id" value="{{$pegawai->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="NIP" required value="{{old('NIP') ? old('NIP') : $pegawai->NIP}}">
                                        <label class="form-label">NIP</label>
                                    </div>
                                    @if ($errors->has('NIP'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('NIP') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama" required value="{{old('nama') ? old('nama') : $pegawai->nama }}">
                                        <label class="form-label">Nama</label>
                                    </div>
                                    @if ($errors->has('nama'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nama') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="jabatan" required value="{{old('jabatan') ? old('jabatan') : $pegawai->jabatan }}">
                                        <label class="form-label">Jabatan</label>
                                    </div>
                                    @if ($errors->has('jabatan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('jabatan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="golongan_id" required="" data-live-search="true">
                                        <option value="">Pilih Golongan</option>
                                        {{'',$old_golongan = old('golongan_id') ? old('golongan_id') : $pegawai->golongan_id }}
                                        @foreach($golongan as $gol)
                                        <option value="{{$gol->id}}" {{$old_golongan == $gol->id ? 'selected=""' : '' }}>{{$gol->nama}} - {{$gol->pangkat}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('golonga_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('golonga_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="eselon_id" required="" data-live-search="true">
                                        <option value="">Pilih Eselon</option>
                                        {{'',$old_eselon = old('eselon_id') ? old('eselon_id') : $pegawai->eselon_id }}
                                        @foreach($eselon as $es)
                                        <option value="{{$es->id}}" {{$old_eselon == $es->id ? 'selected=""' : '' }}>{{$es->nama}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('eselon_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('eselon_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <h2 class="card-inside-title">Account Information</h2>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" class="form-control" name="email" required value="{{old('email') ? old('email') : $pegawai->user->email}}">
                                        <label class="form-label">E-Mail</label>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
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
                                    @if ($errors->has('level'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('level') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="status_pptk" required="">
                                        <option value="">Pilih Status PPTK</option>
                                        {{'',$old_status = old('status_pptk') ? old('status_pptk') : $pegawai->status_pptk}}
                                        @foreach([0 => 'Tidak',1 => 'PPTK'] as $status => $value)
                                        <option value="{{$status}}" {{$old_status == $status ? 'selected=""' : '' }}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status_pptk'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status_pptk') }}</strong>
                                        </span>
                                    @endif
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