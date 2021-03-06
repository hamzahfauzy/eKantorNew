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
                            <div class="pull-right">
                                @if(!auth()->user()->employee->kepala_group_special_role())
                                <a href="{{route('pegawai.surat-masuk.create')}}" class="btn btn-primary waves-effect">
                                    <i class="material-icons">add</i> 
                                    <span>TAMBAH DATA</span>
                                </a>
                                @endif
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
                                            <th>No. Agenda</th>
                                            <th>Surat</th>
                                            <th>Tanggal Surat</th>
                                            <th>Sumber</th>
                                            <th>Histori</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>No. Agenda</th>
                                            <th>Surat</th>
                                            <th>Tanggal Surat</th>
                                            <th>Sumber</th>
                                            <th>Histori</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($surat as $model)
                                        @php $histori = $model->histori()->orderby('created_at','desc')->first() @endphp
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>
                                                <b>{{$model->no_agenda}}</b><br>
                                                {{$model->created_at->format('j F, Y')}}<br>

                                                @if(!auth()->user()->employee->kepala_group_special_role())
                                                    @if($model->arsip)
                                                        No. Arsip : {{$model->arsip->no_arsip}}
                                                    @else
                                                        <a href="javascript:void(0)" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#defaultModal{{$model->id}}">Arsipkan Surat</a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                No. Surat: <b>{{$model->no_surat}}</b><br>
                                                Perihal: {{$model->perihal}}<br>
                                                Sifat: {{$model->sifat_surat}}<br>
                                                Keterangan:<br>
                                                {{$model->keterangan}}<br>
                                            </td>
                                            <td>{{$model->tanggal_surat->format('j F Y')}}</td>
                                            <td>{{$model->sumber_surat}}</td>
                                            <td>
                                                @if($histori)
                                                {{$histori->status}}<br><b>{{$histori->created_at->format('j F Y')}}</b>
                                                @else
                                                Surat Masuk <br> <b>{{$model->created_at->format('j F Y')}}</b>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{Storage::url($model->file_url_surat)}}" target="_blank" class="btn btn-info waves-effect">
                                                    <i class="material-icons">get_app</i>
                                                    
                                                </a>

                                                <a href="{{route('detail-surat-masuk',$model->id)}}" class="btn btn-secondary waves-effect">
                                                    <i class="material-icons">visibility</i>
                                                    
                                                </a>

                                                @if(auth()->user()->employee->kepala_group_special_role() && empty($model->status_teruskan) && count($model->disposisis) == 0)
                                                <a href="{{route('pegawai.surat-masuk.teruskan')}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();teruskanAlert({{$model->id}})">
                                                    <i class="material-icons">arrow_forward</i>
                                                    
                                                </a>

                                                <form id="form-teruskan-{{$model->id}}" style="display: none;" method="post" action="{{route('pegawai.surat-masuk.teruskan')}}">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" value="{{$model->id}}">
                                                </form>
                                                @endif

                                                @if(!auth()->user()->employee->kepala_group_special_role())

                                                    <a href="{{route('pegawai.surat-masuk.edit',$model->id)}}" class="btn btn-warning waves-effect">
    				                                    <i class="material-icons">create</i>
    				                                    
    				                                </a>

                                                    @if($model->histori && $model->histori()->orderby('created_at','desc')->first() && $model->histori()->orderby('created_at','desc')->first()->status == 'Surat Masuk')
    				                                <a href="{{route('pegawai.surat-masuk.delete')}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();deleteAlert({{$model->id}})">
    				                                    <i class="material-icons">delete</i>
    				                                </a>

    				                                <form id="form-delete-{{$model->id}}" style="display: none;" method="post" action="{{route('pegawai.surat-masuk.delete')}}">
    				                                	{{csrf_field()}}
    				                                	<input type="hidden" name="_method" value="DELETE">
    				                                	<input type="hidden" name="id" value="{{$model->id}}">
    				                                </form>
                                                    @endif

                                                @endif
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="defaultModal{{$model->id}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="defaultModalLabel">Arsip Surat Masuk</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="form_validation" method="POST" action="{{route('pegawai.surat-masuk.arsip')}}">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="id" value="{{$model->id}}">
                                                            <div class="form-group form-float">
                                                                <label>No. Arsip</label>
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" name="no_arsip" required>
                                                                    <label class="form-label">No Arsip</label>
                                                                </div>
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

function teruskanAlert(id)
{
    swal({
        title: 'Apakah anda yakin akan meneruskan surat ini?',
        text: "Perubahan tidak dapat dikembalikan!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        confirmCancelText: 'Batal!'
    },function (isConfirm) {
        if (isConfirm) {
            $("#form-teruskan-"+id).submit()
        }
    });
}
</script>
@endsection