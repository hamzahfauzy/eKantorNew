@extends('bsbmtemplate.admin-template')
@section('surat-active','active')
@section('surat-masuk-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Surat Masuk
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                List Data Surat Masuk
                            </h2>
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
                                            <th>No. Agenda</th>
                                            <th>Surat</th>
                                            <th>Tanggal Surat</th>
                                            <th>Tanggal Terima</th>
                                            <th>Sumber</th>
                                            <th>Pegawai</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>No. Agenda</th>
                                            <th>Surat</th>
                                            <th>Tanggal Surat</th>
                                            <th>Tanggal Terima</th>
                                            <th>Sumber</th>
                                            <th>Pegawai</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($surat as $model)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>
                                                <b>{{$model->no_agenda}}</b>
                                            </td>
                                            <td>
                                                No. Surat: <b>{{$model->no_surat}}</b><br>
                                                Perihal: {{$model->perihal}}<br>
                                                {{$model->keterangan}}<br>
                                            </td>
                                            <td>{{$model->tanggal_surat->format('j F Y')}}</td>
                                            <td>{{$model->tanggal_terima->format('j F Y')}}</td>
                                            <td>{{$model->sumber_surat}}</td>
                                            <td>{{$model->employee->nama}}</td>
                                            <td>
                                            	<a href="{{Storage::url($model->file_url_surat)}}" target="_blank" class="btn btn-info waves-effect">
                                                    <i class="material-icons">get_app</i>
                                                    
                                                </a>

                                                <a href="{{route('pimpinan.surat.show',$model->id)}}" class="btn btn-warning waves-effect">
				                                    <i class="material-icons">visibility</i>
				                                    
				                                </a>
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