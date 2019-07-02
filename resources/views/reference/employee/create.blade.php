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
                            <h2>Tambah Data Pegawai</h2>
                        </div>
                        <div class="body">
                            <h2 class="card-inside-title">Personal Information</h2>
                            <form id="form_validation" method="POST" action="{{route('reference.employee.insert')}}">
                            	{{csrf_field()}}
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="NIP" required value="{{old('NIP')}}">
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
                                        <input type="text" class="form-control" name="nama" required value="{{old('nama')}}">
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
                                        <input type="text" class="form-control" name="jabatan" required value="{{old('jabatan')}}">
                                        <label class="form-label">Jabatan</label>
                                    </div>
                                    @if ($errors->has('jabatan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('jabatan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="golongan_id" required="">
                                        <option value="">Pilih Golongan</option>
                                        @foreach($golongan as $gol)
                                        <option value="{{$gol->id}}" {{old('golongan_id') == $gol->id ? 'selected=""' : '' }}>{{$gol->nama}} - {{$gol->pangkat}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('golongan_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('golongan_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="eselon_id" required="">
                                        <option value="">Pilih Eselon</option>
                                        @foreach($eselon as $es)
                                        <option value="{{$es->id}}" {{old('eselon_id') == $es->id ? 'selected=""' : '' }}>{{$es->nama}}</option>
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
                                        <input type="email" class="form-control" name="email" required value="{{old('email')}}">
                                        <label class="form-label">E-Mail</label>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password" required>
                                        <label class="form-label">Password</label>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="level" required="">
                                        <option value="">Pilih Level</option>
                                        @foreach(['admin','pegawai'] as $level)
                                        <option value="{{$level}}" {{old('level') == $level ? 'selected=""' : '' }}>{{$level}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('level'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('level') }}</strong>
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