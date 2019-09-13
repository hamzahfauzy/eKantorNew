@extends('bsbmtemplate.admin-template')
@section('pkr-active','active')
@section('kegiatan-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Kegiatan
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                List Data Kegiatan
                            </h2>
                            <div class="pull-right">
                                <a href="{{route('reference.kegiatan.create')}}" class="btn btn-primary waves-effect">
                                    <i class="material-icons">add</i> 
                                    <span>TAMBAH DATA</span>
                                </a>
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
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable w-auto">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="15%">Kd Kegiatan</th>
                                            <th>Nama</th>
                                            <th>Program</th>
                                            <th width="20%">Pagu Dalam Daerah</th>
                                            <th width="20%">Pagu Luar Daerah</th>
                                            <th>Saldo</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th width="15%">Kd Kegiatan</th>
                                            <th>Nama</th>
                                            <th>Program</th>
                                            <th width="20%">Pagu Dalam Daerah</th>
                                            <th width="20%">Pagu Luar Daerah</th>
                                            <th>Saldo</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($kegiatan as $model)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$model->program->kd_program.'.'.$model->kd_kegiatan}}</td>
                                            <td>
                                            {{$model->nama}}
                                            </td>
                                            <td>
                                                {{$model->program->nama}}
                                            </td>
                                            <td>
                                            Rp. <b>{{number_format($model->pagu_dalam_daerah,2,',','.')}}</b><br>
                                            </td>
                                            <td>
                                            Rp. <b>{{number_format($model->pagu_luar_daerah,2,',','.')}}</b><br>
                                            </td>
                                            <td>
                                            Rp. <b>{{number_format($model->pagu_dalam_daerah+$model->pagu_luar_daerah,2,',','.')}}</b>
                                            </td>
                                            <td>
                                            	<a href="{{route('reference.kegiatan.edit',$model->id)}}" class="btn btn-warning waves-effect">
				                                    <i class="material-icons">create</i>
				                                    <span>Edit</span>
				                                </a>

				                                <a href="{{route('reference.kegiatan.delete')}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();deleteAlert({{$model->id}})">
				                                    <i class="material-icons">delete</i>
				                                    <span>Hapus</span>
				                                </a>

				                                <form id="form-delete-{{$model->id}}" style="display: none;" method="post" action="{{route('reference.kegiatan.delete')}}">
				                                	{{csrf_field()}}
				                                	<input type="hidden" name="_method" value="DELETE">
				                                	<input type="hidden" name="id" value="{{$model->id}}">
				                                </form>
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
</script>
@endsection