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
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                List Data SPT
                            </h2>
                            <div class="pull-right">
                                <a href="{{route('pegawai.spt-role.create')}}" class="btn btn-primary waves-effect">
                                    <i class="material-icons">add</i> 
                                    <span>TAMBAH DATA</span>
                                </a>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-rekapitulasi" class="btn btn-warning waves-effect">
                                    <i class="material-icons">print</i> 
                                    <span>CETAK REKAPITULASI</span>
                                </a>
                                <div class="modal fade" id="modal-rekapitulasi" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="defaultModalLabel">Cetak Rekapitulasi SPT</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="box">
                                                <form action="{{route('pegawai.spt-role.rekapitulasi')}}" target="_blank">
                                                <div class="form-group form-float">
                                                    <select class="form-control show-tick pengikut" name="employee_id" required="" data-live-search="true">
                                                    <option value="0">Semua</option>
                                                    @foreach($employees as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->nama}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <label>Tanggal Awal</label>
                                                        <input type="text" class="datepicker from form-control" name="tanggal_awal" placeholder="Tanggal Awal" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <label>Tanggal Akhir</label>
                                                        <input type="text" class="datepicker to form-control" name="tanggal_akhir" placeholder="Tanggal Akhir" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <label>Tahun Anggaran</label>
                                                        <input type="text" class="form-control" name="tahun_anggaran" placeholder="Tahun Anggaran" required="">
                                                    </div>
                                                </div>
                                                <button class="btn btn-warning"><i class="material-icons">print</i> CETAK REKAPITULASI</button>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>No SPT</th>
                                            <th>Maksud</th>
                                            <th>Tujuan</th>
                                            <th>Tanggal</th>
                                            <th>Pegawai</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>No SPT</th>
                                            <th>Maksud</th>
                                            <th>Tujuan</th>
                                            <th>Tanggal</th>
                                            <th>Pegawai</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($spt as $model)
                                        <?php $maksud_tujuan = explode("\n",$model->maksud_tujuan);?>
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>
                                            {{$model->no_spt}}<br>
                                            {{$model->tanggal->formatLocalized("%d %B %Y")}}
                                            </td>
                                            <td>
                                            {{$maksud_tujuan[0]}}
                                            <br>
                                            <span class="label label-default">{{$model->lama_waktu}} Hari</span>
                                            </td>
                                            <td>
                                            {{$model->tempat_tujuan}}
                                            </td>
                                            <td>
                                            <span class="label label-default">
                                            {{$model->tanggal_awal->formatLocalized("%d %B %Y")}} - 
                                            {{$model->tanggal_akhir->formatLocalized("%d %B %Y")}}
                                            </span>
                                            </td>
                                            <td><a href="javascript:void(0)" data-toggle="modal" data-target="#defaultModal{{$model->id}}"class="label label-primary">Lihat Pegawai</a></td>
                                            <td>
                                                <a href="{{route('pegawai.spt-role.cetak',$model->id)}}" class="btn btn-primary waves-effect">
				                                    <i class="material-icons">visibility</i>
				                                    <span>Lihat</span>
				                                </a>
                                                
                                                <a href="{{route('pegawai.spt-role.edit',$model->id)}}" class="btn btn-warning waves-effect">
				                                    <i class="material-icons">create</i>
				                                    <span>Edit</span>
				                                </a>

				                                <a href="{{route('pegawai.spt-role.delete')}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();deleteAlert({{$model->id}})">
				                                    <i class="material-icons">delete</i>
				                                    <span>Hapus</span>
				                                </a>

				                                <form id="form-delete-{{$model->id}}" style="display: none;" method="post" action="{{route('pegawai.spt-role.delete')}}">
				                                	{{csrf_field()}}
				                                	<input type="hidden" name="_method" value="DELETE">
				                                	<input type="hidden" name="id" value="{{$model->id}}">
				                                </form>
                                                <div class="modal fade" id="defaultModal{{$model->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="defaultModalLabel">Pegawai Pada No SPT : {{$model->no_spt}}</h4>
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
        url:"{{route('pegawai.spt-role.set-urutan')}}",
        data:{id:id,urutan:urutan},
        success:function(data){
            alert('No Urut berhasil disimpan')
        }
    });
}
</script>
<!-- Select Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
<!-- Moment Plugin Js -->
<script src="{{asset('template/bsbm/plugins/momentjs/moment.js')}}"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script type="text/javascript">
$('input.datepicker.to').bootstrapMaterialDatePicker({
    clearButton: true,
    weekStart: 1,
    time: false
});
$('input.datepicker.from').bootstrapMaterialDatePicker({
    clearButton: true,
    weekStart: 1,
    time: false
}).on('change',function(e, date){
    $('input.datepicker.to').bootstrapMaterialDatePicker('setMinDate', date);
});

</script>
@endsection