@extends('bsbmtemplate.admin-template')
@section('profil-active','active')
@section('content')
<?php $pegawai = auth()->user()->employee ?>
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Profil
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                {{$pegawai->nama}}
                            </h2>
                            <div class="pull-right">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <form id="form_validation" method="POST" action="{{route('update-profil')}}">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="id" value="{{$pegawai->id}}">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="NIP" required value="{{$pegawai->NIP}}">
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
                                                    <input type="text" class="form-control" name="nama" required value="{{$pegawai->nama }}">
                                                    <label class="form-label">Nama</label>
                                                </div>
                                                @if ($errors->has('nama'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('nama') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <h2 class="card-inside-title">Account Information</h2>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="email" class="form-control" name="email" required value="{{$pegawai->user->email}}">
                                                    <label class="form-label">E-Mail</label>
                                                </div>
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group form-float">
                                                <label>*kosongkan password jika tidak diganti</label>
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="password">
                                                    <label class="form-label">Password</label>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <form  id="form_validation" action="{{route('update-avatar')}}" method="post" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <input type="hidden" name="id" value="{{$pegawai->id}}">
                                            @if(!empty(auth()->user()->avatar))
                                            <img src="{{Storage::url(auth()->user()->avatar->avatar_url)}}" alt="{{$pegawai->nama}}" width="150px">
                                            @endif
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label>Avatar</label>
                                                    <input type="file" class="form-control" name="avatar" required>
                                                </div>
                                                @if ($errors->has('avatar'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('avatar') }}</strong>
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
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
@endsection
@section('script')
<!-- Select Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript">
function deleteAlert(id)
{
    swal({
        title: 'Apakah anda yakin akan menghapus data ini?',
        text: "Perubahan tidak dapat dikembalikan!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        confirmCancelText: 'Batal!'
    },function (isConfirm) {
        if (isConfirm) {
            $("#form-delete-"+id).submit()
        }
    });
}
</script>
@endsection