@extends('bsbmtemplate.admin-template')
@section('kepegawaian-active','active')
@section('group-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Staff {{$sub->nama}}
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                        	Details {{$sub->nama}}
                        </div>
                        <div class="body">
                        	<div class="row">
                        		<div class="col-sm-12 col-md-6">
                        			<h3>Group Detail</h3>
                        			<span>Nama Group</span><br>
                        			<b>{{$group->nama}}</b><br>
                        			<br>

                        			<span>Pimpinan</span><br>
                        			<a href="{{route('reference.employee.show',$group->kepala_id)}}">
                        				{{$group->kepala->nama}}
                        			</a>
                        			<br><br>
                        			<a href="{{route('reference.group.edit',$group->id)}}" class="btn btn-warning waves-effect">
				                        <i class="material-icons">create</i>
				                        <span>Edit</span>
				                    </a>

				                    <a href="{{route('reference.group.delete')}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();deleteGroup({{$group->id}})">
				                    	<i class="material-icons">delete</i>
				                    	<span>Hapus</span>
				                    </a>

				                    <form id="form-deleteGroup-{{$group->id}}" style="display: none;" method="post" action="{{route('reference.group.delete')}}">
				                    	@csrf
				                        <input type="hidden" name="_method" value="DELETE">
				                        <input type="hidden" name="id" value="{{$group->id}}">
				                    </form>

				                    <h3>Sub Group Detail</h3>
                        			<span>Nama Sub Group</span><br>
                        			<b>{{$sub->nama}}</b><br>
                        			<br>

                        			<span>Pimpinan</span><br>
                        			<a href="{{route('reference.employee.show',$sub->kepala_id)}}">
                        				{{$sub->kepala->nama}}
                        			</a>
                        			<br><br>
                        			<a href="{{route('reference.group.sub.edit',[$group->id,$sub->id])}}" class="btn btn-warning waves-effect">
				                        <i class="material-icons">create</i>
				                        <span>Edit</span>
				                    </a>

				                    <a href="{{route('reference.group.sub.delete',[$group->id,$sub->id])}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();deleteSubGroup({{$group->id}})">
				                    	<i class="material-icons">delete</i>
				                    	<span>Hapus</span>
				                    </a>

				                    <form id="form-deleteSubGroup-{{$group->id}}" style="display: none;" method="post" action="{{route('reference.group.sub.delete',[$group->id,$sub->id])}}">
				                    	@csrf
				                        <input type="hidden" name="_method" value="DELETE">
				                        <input type="hidden" name="id" value="{{$sub->id}}">
				                    </form>
		                        </div>
	                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                List Data Staff {{$sub->nama}}
                            </h2>
                            <div class="pull-right">
                            	<a href="{{route('reference.group.sub.staff.create',[$group->id,$sub->id])}}" class="btn btn-primary waves-effect">
                                    <i class="material-icons">add</i> 
                                    <span>TAMBAH DATA</span>
                                </a>
                                <a href="{{route('reference.group.show',$group->id)}}" class="btn btn-warning waves-effect">
                                    <i class="material-icons">arrow_back</i> 
                                    <span>KEMBALI</span>
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
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Golongan</th>
                                            <th>Eselon</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Golongan</th>
                                            <th>Eselon</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{'',$no=1}}
                                        @foreach($sub->subGroupStaffs as $model)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>
                                                <b>{{$model->employee->NIP}}</b>
                                            </td>
                                            <td>
                                                {{$model->employee->nama}}
                                            </td>
                                            <td>{{$model->employee->jabatan}}</td>
                                            <td>{{$model->employee->golongan->pangkat}} - {{$model->employee->golongan->nama}}</td>
                                            <td>{{$model->employee->eselon->nama}}</td>
                                            <td>
                                            	<a href="{{route('reference.employee.show',$model->employee->id)}}" class="btn btn-info waves-effect">
                                                    <i class="material-icons">web_asset</i>
                                                    
                                                </a>

				                                <a href="{{route('reference.group.sub.staff.delete',[$group->id,$sub->id])}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();deleteAlert({{$model->employee->id}})">
				                                    <i class="material-icons">delete</i>
				                                    
				                                </a>

				                                <form id="form-delete-{{$model->employee->id}}" style="display: none;" method="post" action="{{route('reference.group.sub.staff.delete',[$group->id,$sub->id])}}">
				                                	@csrf
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

function deleteGroup(id)
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
            $("#form-deleteGroup-"+id).submit()
        }
	});
}

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