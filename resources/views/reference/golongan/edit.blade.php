@extends('bsbmtemplate.admin-template')
@section('kepegawaian-active','active')
@section('golongan-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Golongan
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Edit Data Golongan</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('reference.golongan.update')}}">
                            	@csrf
                            	<input type="hidden" name="_method" value="PUT">
                            	<input type="hidden" name="id" value="{{$golongan->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama" required value="{{$golongan->nama}}">
                                        <label class="form-label">Nama</label>
                                    </div>
                                    @error('nama')
							            <span class="invalid-feedback" role="alert">
							                <strong>{{ $message }}</strong>
							            </span>
							        @enderror
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="pangkat" required value="{{$golongan->pangkat}}">
                                        <label class="form-label">Pangkat</label>
                                    </div>
                                    @error('pangkat')
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