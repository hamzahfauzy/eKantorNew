@extends('bsbmtemplate.admin-template')
@section('disposisi-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Surat Disposisi
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                List Data Surat Disposisi
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
                                            <th>Sumber</th>
                                            <th>Catatan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>No. Agenda</th>
                                            <th>Surat</th>
                                            <th>Sumber</th>
                                            <th>Catatan</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($disposisis as $model)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>
                                                <b>{{$model->surat_masuk->no_agenda}}</b>
                                            </td>
                                            <td>
                                                No. Surat: <b>{{$model->surat_masuk->no_surat}}</b><br>
                                                Perihal: {{$model->surat_masuk->perihal}}<br>
                                                {{$model->surat_masuk->keterangan}}<br>
                                            </td>
                                            <td>{{$model->surat_masuk->sumber_surat}}</td>
                                            <td>{{$model->catatan}}</td>
                                            <td>
                                            	<a href="{{Storage::url($model->surat_masuk->file_url_surat)}}" target="_blank" class="btn btn-info waves-effect">
                                                    <i class="material-icons">get_app</i>
                                                    
                                                </a>

                                                @if(auth()->user()->employee->kepala_group)
                                                <a href="javascript:void(0)" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#defaultModal{{$model->surat_masuk->id}}">
                                                    <i class="material-icons">arrow_forward</i>
                                                    <span>Disposisi</span>
                                                </a>
                                                <div class="modal fade" id="defaultModal{{$model->surat_masuk->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="defaultModalLabel">Set Disposisi Surat</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="form_validation" method="POST" action="{{route('set-disposisi')}}">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" name="surat_id" value="{{$model->surat_masuk->id}}">
                                                                    <div class="form-group form-float">
                                                                        <label>Disposisikan Ke:</label>
                                                                        <select class="form-control show-tick" name="pegawai[]" required="" data-live-search="true" multiple="">
                                                                            @foreach($employees as $employee)
                                                                            <option value="{{$employee->id}}">{{$employee->nama}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group form-float">
                                                                        <label>Catatan</label>
                                                                        <div class="form-line">
                                                                            <textarea class="form-control" name="catatan" required></textarea>
                                                                            <label class="form-label">Catatan</label>
                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <a href="{{route('detail-surat-masuk',$model->surat_masuk_id)}}" class="btn btn-warning waves-effect">
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
<script src="{{asset('template/bsbm/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
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