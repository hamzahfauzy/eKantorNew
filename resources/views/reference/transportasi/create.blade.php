@extends('bsbmtemplate.admin-template')
@section('transportasi-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Transportasi
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Tambah Data Transportasi</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('reference.transportasi.insert')}}">
                            	{{csrf_field()}}
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
                                        <input type="text" class="form-control" name="status_maskapai" required value="{{old('status_maskapai')}}">
                                        <label class="form-label">Status Maskapai (1 : Maskapai Penerbangan, Kosongkan jika tidak)</label>
                                    </div>
                                    @if ($errors->has('status_maskapai'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status_maskapai') }}</strong>
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