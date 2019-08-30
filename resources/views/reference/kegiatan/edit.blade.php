@extends('bsbmtemplate.admin-template')
@section('pkr-active','active')
@section('kegiatan-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Kegiatan
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Edit Data Kegiatan</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('reference.kegiatan.update')}}">
                            	{{csrf_field()}}
                            	<input type="hidden" name="_method" value="PUT">
                            	<input type="hidden" name="id" value="{{$model->id}}">
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="program_id" required="" data-live-search="true">
                                        <option value="">Pilih Program</option>
                                        {{'',$old_program_id = old('program_id') ? old('program_id') : $model->program_id}}
                                        @foreach($programs as $program)
                                        <option value="{{$program->id}}" {{$old_program_id == $program->id ? 'selected=""' : '' }}>{{$program->nama}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('program_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('program_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="kd_kegiatan" required value="{{old('kd_kegiatan') ? old('kd_kegiatan') : $model->kd_kegiatan}}">
                                        <label class="form-label">Kode Kegiatan</label>
                                    </div>
                                    @if ($errors->has('kd_kegiatan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('kd_kegiatan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama" required value="{{old('nama') ? old('nama') : $model->nama}}">
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
                                        <input type="text" class="form-control" name="pagu_kegiatan" required value="{{old('pagu_kegiatan') ? old('pagu_kegiatan') : $model->pagu_kegiatan}}">
                                        <label class="form-label">Pagu Kegiatan</label>
                                    </div>
                                    @if ($errors->has('pagu_kegiatan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('pagu_kegiatan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="pptk_id" required="" data-live-search="true">
                                        <option value="">Pilih PPTK</option>
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}" {{old('pptk_id') == $employee->id ? 'selected=""' : '' }}>{{$employee->nama}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('pptk_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('pptk_id') }}</strong>
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