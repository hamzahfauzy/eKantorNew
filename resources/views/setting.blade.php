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
                            	{{csrf_field()}}
                                <input type="hidden" name="_method" value="PUT">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama" required value="{{old('nama') ? old('nama') : $model->nama}}">
                                        <label class="form-label">Nama Instansi</label>
                                    </div>
                                    @if ($errors->has('nama'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nama') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="alamat" required value="{{old('alamat') ? old('alamat') : $model->alamat}}">
                                        <label class="form-label">Alamat</label>
                                    </div>
                                    @if ($errors->has('alamat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('alamat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <label>Pimpinan</label>
                                    <select class="form-control show-tick" name="pimpinan_id" required="" data-live-search="true">
                                        {{'',$old_pimpinan = old('pimpinan_id') ? old('pimpinan_id') : $model->pimpinan_id}}
                                        @foreach($pimpinan as $data)
                                        <option value="{{$data->id}}" {{$old_pimpinan == $data->id ? 'selected=""' : '' }}>{{$data->nama}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('pimpinan_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('pimpinan_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    {{'',$old_group = old('group_special_role_id') ? old('group_special_role_id') : $model->group_special_role_id}}
                                    <label>Group Special Role</label>
                                    <select class="form-control show-tick group_special_role" name="group_special_role_id" required="" data-live-search="true">
                                        @foreach($groups as $group)
                                            @foreach($group->subGroups as $data)
                                            <option value="{{$data->id}}" {{$old_group == $data->id ? 'selected=""' : '' }}>{{$data->nama}}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @if ($errors->has('group_special_role_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('group_special_role_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    {{'',$old_group_user_id = old('group_special_role_user_id') ? old('group_special_role_user_id') : $model->group_special_role_user_id}}
                                    <label>Group Special Role User</label>
                                    <select class="form-control user_special_role show-tick" name="group_special_role_user_id" data-live-search="true">
                                        @if($model->special)
                                        @foreach($model->special->subGroupStaffs as $data)
                                        <option value="{{$data->pegawai_id}}" {{$old_group_user_id == $data->pegawai_id ? 'selected=""' : '' }}>{{$data->employee->nama}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('group_special_role_user_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('group_special_role_user_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <label>Logo</label>
                                    @if(!empty($model->logo))
                                    <img src="{{Storage::url($model->logo)}}" class="img-responsive" width="250px">
                                    @endif
                                    <input type="file" name="logo" class="form-control" style="height: auto;">
                                    @if ($errors->has('logo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('logo') }}</strong>
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

<!-- Dropzone Plugin Js -->
<script src="{{asset('template/bsbm/plugins/dropzone/dropzone.js')}}"></script>

<script>
$(".group_special_role").change(function(){
    
})
</script>
@endsection