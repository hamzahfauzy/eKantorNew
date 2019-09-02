@extends('bsbmtemplate.admin-template')
@section('spt-sppd-active','active')
@section('sppd-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data SPPD
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                List Data SPPD
                            </h2>
                            @if(!empty(auth()->user()->employee->isPptk))
                            <div class="pull-right">
                                <a href="{{$spt_add_url=route('pegawai.sppd.create')}}" class="btn btn-primary waves-effect">
                                    <i class="material-icons">add</i> 
                                    <span>TAMBAH DATA</span>
                                </a>
                            </div>
                            @endif
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SPT</th>
                                            <th>SPPD</th>
                                            <th>Transportasi</th>
                                            <th>Total Biaya (Rp)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>SPT</th>
                                            <th>SPPD</th>
                                            <th>Transportasi</th>
                                            <th>Total Biaya (Rp)</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($sppd as $model)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>
                                                <b>No. SPT</b> : {{$model->spt->no_spt}}
                                                <br>
                                                <b>Tanggal</b> : {{$model->spt->tanggal->formatLocalized('%d %B %Y')}}<br>
                                                <b>Tujuan</b> : {{$model->spt->tempat_tujuan}}<br>
                                                <b>Lama Waktu</b> : {{$model->spt->lama_waktu}} Hari
                                            </td>
                                            <td>
                                                {{$model->no_sppd}}
                                                @if(!empty(auth()->user()->employee->isPptk))
                                                <br>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#defaultModal{{$model->id}}" class="label label-primary">Lihat Pegawai</a>
                                                @endif
                                            </td>
                                            <td>
                                                {{$model->transportation->nama}}
                                                @if($model->transportation->status_maskapai)
                                                <style>
                                                .maskapai .form-group {
                                                    margin-bottom:25px !important;
                                                }
                                                </style>
                                                @if(!empty(auth()->user()->employee->isPptk))
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#maskapai{{$model->id}}"class="label label-primary">Set Maskapai</a>
                                                <div class="modal fade maskapai" id="maskapai{{$model->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="defaultModalLabel">Set Maskapai</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="box">
                                                                    <h5>Maskapai Berangkat</h5>
                                                                    <form method="post" id="form_validation" action="{{route('pegawai.sppd.set-maskapai')}}">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" name="sppd_id" value="{{$model->id}}">
                                                                        <input type="hidden" name="status" value="1">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="nama maskapai" required value="{{$model->maskapai_berangkat ? $model->maskapai_berangkat->nama_maskapai : ''}}">
                                                                                <label class="form-label">Nama Maskapai</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="no_tiket" required value="{{$model->maskapai_berangkat ? $model->maskapai_berangkat->no_tiket : ''}}">
                                                                                <label class="form-label">No Tiket</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="id_booking" required value="{{$model->maskapai_berangkat ? $model->maskapai_berangkat->id_booking : ''}}">
                                                                                <label class="form-label">ID Booking</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="date" class="form-control" name="tanggal_checkin" required value="{{$model->maskapai_berangkat ? $model->maskapai_berangkat->tanggal_checkin : ''}}">
                                                                                <label class="form-label">Tanggal Check-in</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="harga_tiket" required value="{{$model->maskapai_berangkat ? $model->maskapai_berangkat->harga_tiket : ''}}">
                                                                                <label class="form-label">Harga Tiket</label>
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn btn-primary">Simpan</button>
                                                                    </form>
                                                                </div>

                                                                <div class="box">
                                                                <br>
                                                                    <h5>Maskapai Kembali</h5>
                                                                    <form method="post" id="form_validation" action="{{route('pegawai.sppd.set-maskapai')}}">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" name="sppd_id" value="{{$model->id}}">
                                                                        <input type="hidden" name="status" value="2">
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="nama maskapai" required value="{{$model->maskapai_kembali ? $model->maskapai_kembali->nama_maskapai : ''}}">
                                                                                <label class="form-label">Nama Maskapai</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="no_tiket" required value="{{$model->maskapai_kembali ? $model->maskapai_kembali->no_tiket : ''}}">
                                                                                <label class="form-label">No Tiket</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="id_booking" required value="{{$model->maskapai_kembali ? $model->maskapai_kembali->id_booking : ''}}">
                                                                                <label class="form-label">ID Booking</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="date" class="form-control" name="tanggal_checkin" required value="{{$model->maskapai_kembali ? $model->maskapai_kembali->tanggal_checkin : ''}}">
                                                                                <label class="form-label">Tanggal Check-in</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-float">
                                                                            <div class="form-line">
                                                                                <input type="text" class="form-control" name="harga_tiket" required value="{{$model->maskapai_kembali ? $model->maskapai_kembali->harga_tiket : ''}}">
                                                                                <label class="form-label">Harga Tiket</label>
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn btn-primary">Simpan</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endif
                                            </td>
                                            <td>
                                            {{number_format($model->total_biaya)}}
                                            @if(!empty(auth()->user()->employee->isPptk))
                                            <br>
                                            <a href="{{route('pegawai.sppd.detail-biaya',$model->id)}}">Detail Biaya</a>
                                            @endif
                                            </td>
                                            <td>
                                                <a href="{{route('pegawai.sppd.cetak',$model->id)}}" class="btn btn-primary waves-effect">
				                                    <i class="material-icons">visibility</i>
				                                    <span>Lihat</span>
				                                </a>
                                                @if(!empty(auth()->user()->employee->isPptk))
                                                <a href="{{route('pegawai.sppd.edit',$model->id)}}" class="btn btn-warning waves-effect">
				                                    <i class="material-icons">create</i>
				                                    <span>Edit</span>
				                                </a>

				                                <a href="{{route('pegawai.sppd.delete')}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();deleteAlert({{$model->id}})">
				                                    <i class="material-icons">delete</i>
				                                    <span>Hapus</span>
				                                </a>
                                                @endif

				                                <form id="form-delete-{{$model->id}}" style="display: none;" method="post" action="{{route('pegawai.sppd.delete')}}">
				                                	{{csrf_field()}}
				                                	<input type="hidden" name="_method" value="DELETE">
				                                	<input type="hidden" name="id" value="{{$model->id}}">
				                                </form>
                                                <div class="modal fade" id="defaultModal{{$model->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="defaultModalLabel">Pegawai Pada No SPPD : {{$model->no_sppd}}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table">
                                                                @foreach($model->employees()->orderby('no_urut','asc')->get() as $key => $employee)
                                                                <tr>
                                                                    <td rowspan="5">{{++$key}}</td>
                                                                    <td>Nama</td>
                                                                    <td>:</td>
                                                                    <td>{{$employee->employee->nama}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>NIP</td>
                                                                    <td>:</td>
                                                                    <td>{{$employee->employee->NIP}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pangkat/Gol. Ruang</td>
                                                                    <td>:</td>
                                                                    <td>{{$employee->employee->golongan->nama}} ({{$employee->employee->golongan->pangkat}})</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Jabatan</td>
                                                                    <td>:</td>
                                                                    <td>{{$employee->employee->jabatan}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Urutan</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                    <input type="number" class="form-control" name="urutan_{{$employee->id}}" value="{{$employee->no_urut}}">
                                                                    <button class="btn btn-primary" onclick="simpanUrutan({{$employee->id}})">Simpan</button>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
@endsection

@section('script')
<!-- Jquery DataTable Plugin Js -->
<script src="{{asset('template/bsbm/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
<script src="{{asset('template/bsbm/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

<!-- Sweet Alert Plugin Js -->
<script src="{{asset('template/bsbm/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript">
$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });
});

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

function simpanUrutan(id)
{
    var urutan = $('input[name=urutan_'+id+']').val()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type:'POST',
        url:"{{route('pegawai.sppd.set-urutan')}}",
        data:{id:id,urutan:urutan},
        success:function(data){
            alert('No Urut berhasil disimpan')
        }
    });
}
</script>
</script>
@endsection