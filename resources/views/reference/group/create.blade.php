@extends('bsbmtemplate.admin-template')
@section('kepegawaian-active','active')
@section('group-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Group
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Tambah Data Group</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('reference.group.insert')}}">
                            	@csrf
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama" required value="{{old('nama')}}">
                                        <label class="form-label">Nama</label>
                                    </div>
                                    @error('nama')
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $message }}</strong>
							            </span>
							        @enderror
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="kepala_id" required="">
                                        <option value="">Pilih Pimpinan</option>
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}" {{old('kepala_id') == $employee->id ? 'selected=""' : '' }}>{{$employee->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('kepala_id')
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $message }}</strong>
							            </span>
							        @enderror
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