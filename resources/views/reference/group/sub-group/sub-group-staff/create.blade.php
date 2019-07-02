@extends('bsbmtemplate.admin-template')
@section('kepegawaian-active','active')
@section('group-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Staff Sub Group ({{$sub->nama}})
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                        	<div class="pull-left">
                            	<h2>Tambah Data Staff Sub Group</h2>
                            </div>
                            <div class="pull-right">
                                <a href="{{route('reference.group.sub.show',[$group->id,$sub->id])}}" class="btn btn-warning waves-effect">
                                    <i class="material-icons">arrow_back</i> 
                                    <span>KEMBALI</span>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('reference.group.sub.staff.insert',[$group->id,$sub->id])}}">
                            	@csrf
                            	<input type="hidden" name="sub_group_id" value="{{$sub->id}}">
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="pegawai_id" required="">
                                        <option value="">Pilih Pegawai</option>
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}" {{old('pegawai_id') == $employee->id ? 'selected=""' : '' }}>{{$employee->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('pegawai_id')
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