@extends('bsbmtemplate.admin-template')
@section('wilayah-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Wilayah Tujuan
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Edit Data Wilayah Tujuan</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('reference.wilayah.update')}}">
                            	{{csrf_field()}}
                            	<input type="hidden" name="_method" value="PUT">
                            	<input type="hidden" name="id" value="{{$wilayah->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="kode" required value="{{$wilayah->kode}}">
                                        <label class="form-label">Kode</label>
                                    </div>
                                    @if ($errors->has('kode'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('kode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="keterangan" required value="{{$wilayah->keterangan}}">
                                        <label class="form-label">keterangan</label>
                                    </div>
                                    @if ($errors->has('keterangan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('keterangan') }}</strong>
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