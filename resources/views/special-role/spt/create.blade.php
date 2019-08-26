@extends('bsbmtemplate.admin-template')
@section('spt-sppd-active','active')
@section('spt-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data SPT
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Tambah No SPT</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('pegawai.spt-role.insert')}}">
                            	{{csrf_field()}}
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="no_spt" required value="{{old('no_spt')}}">
                                        <label class="form-label">No. SPT</label>
                                    </div>
                                    @if ($errors->has('no_spt'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('no_spt') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                <a class="btn btn-warning waves-effect" href="{{url()->previous()}}">KEMBALI</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection