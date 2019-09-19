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
                                <span>
                                    <a href="{{route('edit-profil')}}" class="btn btn-primary">
                                        <i class="material-icons" style="font-size: 14px">create</i>
                                        Edit Profil
                                    </a>
                                </span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body">
                            @if ($message = Session::get('success'))
                              <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                  <strong>{{ $message }}</strong>
                              </div>
                              <p></p>
                            @endif
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <label>NIP: </label><br>
                                        <p>{{$pegawai->NIP}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Nama Lengkap: </label><br>
                                        <p>{{$pegawai->nama}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Jabatan: </label><br>
                                        <p>{{$pegawai->jabatan}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Golongan: </label><br>
                                        <p>{{$pegawai->golongan->pangkat.' - '.$pegawai->golongan->nama}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Eselon: </label><br>
                                        <p>{{$pegawai->eselon->nama}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Email: </label><br>
                                        <p>{{$pegawai->user->email}}</p>
                                    </div>

                                    <div class="col-12">
                                        @if($pegawai->staffGroup)
                                        <label>Staff di:</label><br>
                                        <p>{{$pegawai->staffGroup->subGroups->nama}}</p>
                                        @endif

                                        @if($pegawai->kepala_sub_group)
                                        <label>Kepala di:</label><br>
                                        <p>{{$pegawai->kepala_sub_group->nama}}</p>
                                        @endif

                                        @if($pegawai->kepala_group)
                                        <label>Kepala di:</label><br>
                                        <p>{{$pegawai->kepala_group->nama}}</p>
                                        @endif
                                        
                                        @if($pegawai->isPimpinan())
                                        <label>Pimpinan di: </label><br>
                                        <p>{{App\Model\Setting::find(1)->nama}}</p>
                                        @endif

                                        @if($pegawai->inSpecialRoleUser())
                                        <label>Operator Surat: </label><br>
                                        <p>{{App\Model\Setting::find(1)->nama}}</p>
                                        @endif                                        
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