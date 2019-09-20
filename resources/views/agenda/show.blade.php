@extends('bsbmtemplate.admin-template')
@section('agenda-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Detail Agenda
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                {{$agenda->employee->nama}}
                            </h2>
                            <div class="pull-right">
                                @if((auth()->user()->employee->kepala_group_special_role() || auth()->user()->employee->isPimpinan()) && $agenda->status == 0)
                                <span>
                                    <a href="{{route('agenda.acc',$agenda->id)}}" class="btn btn-success">
                                        <i class="material-icons" style="font-size: 14px">check</i>
                                        Setuju
                                    </a>
                                </span>

                                <span>
                                    <a href="{{route('agenda.tolak',$agenda->id)}}" class="btn btn-warning waves-effect" >
                                        <i class="material-icons" style="font-size: 14px">close</i>
                                        Tolak
                                    </a>
                                </span>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body">
                        <?php $pegawai = $agenda->employee ?>
                            <div class="container-fluid">
                                <div class="row">
                                    <h4>Pegawai</h4>
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
                                    <hr>
                                    <div class="col-12">
                                        <h4>Agenda</h4>
                                        <label>Kegiatan:</label><br>
                                        <p>{{$agenda->kegiatan}}</p>

                                        <label>Tempat:</label><br>
                                        <p>{{$agenda->tempat}}</p>

                                        <label>Tanggal:</label><br>
                                        <p>{{$agenda->tanggal_awal}} - {{$agenda->tanggal_akhir}}</p>

                                        <label>Waktu:</label><br>
                                        <p>{{$agenda->waktu_mulai}} - {{$agenda->waktu_selesai}}</p>
                                                                                
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