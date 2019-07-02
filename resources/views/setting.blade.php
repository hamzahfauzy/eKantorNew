@extends('bsbmtemplate.admin-template')
@section('setting-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Application Setting
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Application Setting</h2>
                        </div>
                        <div class="body">
                            @if ($message = Session::get('success'))
                              <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                  <strong>{{ $message }}</strong>
                              </div>
                              <p></p>
                            @endif
                            <form id="form_validation" method="POST" action="{{route('setting.update')}}" enctype="multipart/form-data">
                            	@csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama" required value="{{old('nama') ? old('nama') : $model->nama}}">
                                        <label class="form-label">Nama Instansi</label>
                                    </div>
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="alamat" required value="{{old('alamat') ? old('alamat') : $model->alamat}}">
                                        <label class="form-label">Alamat</label>
                                    </div>
                                    @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="pimpinan_id" required="" data-live-search="true">
                                        <option value="">Pilih Pimpinan</option>
                                        {{'',$old_pimpinan = old('pimpinan_id') ? old('pimpinan_id') : $model->pimpinan_id}}
                                        @foreach($pimpinan as $data)
                                        <option value="{{$data->id}}" {{$old_pimpinan == $data->id ? 'selected=""' : '' }}>{{$data->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('pimpinan_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    {{'',$old_group = old('group_special_role_id') ? old('group_special_role_id') : $model->group_special_role_id}}
                                    <select class="form-control show-tick" name="group_special_role_id" required="" data-live-search="true">
                                        @foreach($groups as $group)
                                            @foreach($group->subGroups as $data)
                                            <option value="{{$data->id}}" {{$old_group == $data->id ? 'selected=""' : '' }}>{{$data->nama}}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('group_special_role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <label>Logo</label>
                                    @if(!empty($model->logo))
                                    <img src="{{Storage::url($model->logo)}}" class="img-responsive" width="250px">
                                    @endif
                                    <input type="file" name="logo" class="form-control" style="height: auto;">
                                    @error('logo')
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

<!-- Dropzone Plugin Js -->
<script src="{{asset('template/bsbm/plugins/dropzone/dropzone.js')}}"></script>
@endsection