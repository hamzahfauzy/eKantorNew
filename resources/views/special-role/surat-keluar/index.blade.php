@extends('bsbmtemplate.admin-template')
@section('surat-active','active')
@section('surat-keluar-active','active')
@section('content')
<?php $status = ['Sent','Accepted','Declined']; $bg = ["","bg-teal","bg-pink"] ?>
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Surat Keluar
                </h2>
            </div>
            <!-- Tabs With Icon Title -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                List Data Surat Keluar
                            </h2>
                            <div class="pull-right">
                                <a href="{{route('pegawai.surat-keluar.create')}}" class="btn btn-primary waves-effect">
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
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#own_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">email</i> Surat Anda
                                    </a>
                                </li>
                                @if(!auth()->user()->employee->staffGroup)
                                <li role="presentation">
                                    <a href="#staff_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">email</i> Surat Staff
                                    </a>
                                </li>
                                @endif

                                @if(auth()->user()->employee->inSpecialRole())
                                <li role="presentation">
                                    <a href="#staff_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">email</i> Surat Staff
                                    </a>
                                </li>
                                @endif
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="own_with_icon_title">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No. Surat</th>
                                                    <th>Surat</th>
                                                    <th>Tanggal Surat</th>
                                                    <th>Tujuan</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No. Surat</th>
                                                    <th>Surat</th>
                                                    <th>Tanggal Surat</th>
                                                    <th>Tujuan</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                {{'',$no=1}}
                                                @foreach($surat as $model)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>
                                                        <b>{{$model->no_surat}}</b>
                                                        @if($model->arsip_pegawai)
                                                            No. Arsip : {{$model->arsip_pegawai->no_arsip}}
                                                        @else
                                                            @if($model->need_action == -1)
                                                            <br>
                                                            <a href="javascript:void(0)" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#modalArsip{{$model->id}}">Arsipkan Surat</a>
                                                            @endif
                                                        @endif

                                                        @if(!empty($model->no_agenda))
                                                            <br>
                                                            No. Agenda : {!!$model->no_agenda!!}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        Perihal: {{$model->perihal}}<br>
                                                        {{$model->keterangan}}<br>
                                                        @if($model->lastHistori)
                                                        <span class="badge {{$bg[$model->lastHistori->status]}}">{{$status[$model->lastHistori->status]}}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$model->tanggal->format('j F Y')}}</td>
                                                    <td>{{$model->tujuan}}</td>
                                                    <td>
                                                        <a href="{{route('pegawai.surat-keluar.show',$model->id)}}" target="_blank" class="btn btn-info waves-effect">
                                                            <i class="material-icons">visibility</i>
                                                            
                                                        </a>

                                                        @if($model->need_action > -1)
                                                        <a href="{{route('pegawai.surat-keluar.edit',$model->id)}}" class="btn btn-warning waves-effect">
                                                            <i class="material-icons">create</i>
                                                            
                                                        </a>

                                                        <a href="{{route('pegawai.surat-keluar.delete')}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();deleteAlert({{$model->id}})">
                                                            <i class="material-icons">delete</i>
                                                            
                                                        </a>

                                                        <form id="form-delete-{{$model->id}}" style="display: none;" method="post" action="{{route('pegawai.surat-keluar.delete')}}">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="id" value="{{$model->id}}">
                                                        </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="modalArsip{{$model->id}}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="defaultModalLabel">Arsip Surat Keluar</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="form_validation" method="POST" action="{{route('pegawai.surat-keluar.arsip')}}">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" name="id" value="{{$model->id}}">
                                                                    <input type="hidden" name="tipe_arsip" value="arsip pegawai">
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

                                @if(!auth()->user()->employee->staffGroup)
                                <?php $status = ['Received','Accepted','Declined']; $bg = ["","bg-teal","bg-pink"] ?>
                                <div role="tabpanel" class="tab-pane fade" id="staff_with_icon_title">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No. Surat</th>
                                                    <th>Surat</th>
                                                    <th>Tanggal Surat</th>
                                                    <th>Pegawai</th>
                                                    <th>Tujuan</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No. Surat</th>
                                                    <th>Surat</th>
                                                    <th>Tanggal Surat</th>
                                                    <th>Pegawai</th>
                                                    <th>Tujuan</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                {{'',$no=1}}
                                                <?php $suratid = [] ?>
                                                @foreach($surat_staffs as $histori)
                                                <?php $model = $histori->suratKeluar; ?>
                                                    @if(in_array($histori->surat_id,$suratid))
                                                        @continue;
                                                    @endif
                                                <?php $suratid[] = $histori->surat_id; ?>
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>
                                                        <b>{{$model->no_surat}}</b>

                                                        @if(!empty($model->no_agenda))
                                                            <br>
                                                            No. Agenda : {!!$model->no_agenda!!}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        Perihal: {{$model->perihal}}<br>
                                                        {{$model->keterangan}}<br>
                                                        @if($model->hasAction($histori->user_id))
                                                        <span class="badge {{$bg[$model->hasAction($histori->user_id)->status]}}">{{$status[$model->hasAction($histori->user_id)->status]}}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$model->tanggal->format('j F Y')}}</td>
                                                    <td>{{$model->employee->nama}}</td>
                                                    <td>{{$model->tujuan}}</td>
                                                    <td>
                                                        <a href="{{route('pegawai.surat-keluar.show',$model->id)}}" target="_blank" class="btn btn-info waves-effect">
                                                            <i class="material-icons">visibility</i>
                                                            
                                                        </a>

                                                        @if($model->need_action == $histori->posisi)
                                                        <a href="{{route('pegawai.surat-keluar.accept')}}" class="btn btn-success waves-effect" onclick="event.preventDefault();acceptAlert({{$histori->id}})">
                                                            <i class="material-icons">done</i>
                                                            
                                                        </a>

                                                        <a href="{{route('pegawai.surat-keluar.decline')}}" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#defaultModal{{$histori->id}}">
                                                            <i class="material-icons">clear</i>
                                                            
                                                        </a>

                                                        <form id="form-acc-{{$histori->id}}" style="display: none;" method="post" action="{{route('pegawai.surat-keluar.accept')}}">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="id" value="{{$histori->id}}">
                                                        </form>

                                                        <div class="modal fade" id="defaultModal{{$histori->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Tolak Surat</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="form_validation" method="POST" action="{{route('pegawai.surat-keluar.decline')}}">
                                                                            {{csrf_field()}}
                                                                            <input type="hidden" name="id" value="{{$histori->id}}">
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
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif

                                @if(auth()->user()->employee->inSpecialRole())
                                <?php $status = ['Received','Accepted','Declined']; $bg = ["","bg-teal","bg-pink"] ?>
                                <div role="tabpanel" class="tab-pane fade" id="staff_with_icon_title">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No. Surat</th>
                                                    <th>Surat</th>
                                                    <th>Tanggal Surat</th>
                                                    <th>Pegawai</th>
                                                    <th>Tujuan</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No. Surat</th>
                                                    <th>Surat</th>
                                                    <th>Tanggal Surat</th>
                                                    <th>Pegawai</th>
                                                    <th>Tujuan</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                {{'',$no=1}}
                                                <?php $suratid = [] ?>
                                                @foreach($surat_staffs as $histori)
                                                <?php $model = $histori->suratKeluar; ?>
                                                    @if(in_array($histori->surat_id,$suratid))
                                                        @continue;
                                                    @endif
                                                <?php $suratid[] = $histori->surat_id; ?>
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>
                                                        <b>{{$model->no_surat}}</b>  
                                                        @if($model->arsip_operator)
                                                            <br>
                                                            No. Arsip : {{$model->arsip_operator->no_arsip}}
                                                        @else
                                                            @if($model->need_action == -1)
                                                            <br>
                                                            <a href="javascript:void(0)" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#modalArsip{{$model->id}}">Arsipkan Surat</a>
                                                            <div class="modal fade" id="modalArsip{{$model->id}}" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="defaultModalLabel">Arsip Surat Keluar</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form id="form_validation" method="POST" action="{{route('pegawai.surat-keluar.arsip')}}">
                                                                                {{csrf_field()}}
                                                                                <input type="hidden" name="id" value="{{$model->id}}">
                                                                                <input type="hidden" name="tipe_arsip" value="arsip operator">
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
                                                            @endif
                                                        @endif

                                                        @if(!empty($model->no_agenda))
                                                            <br>
                                                            No. Agenda : {!!$model->no_agenda!!}
                                                        @endif

                                                        @if(empty($model->no_agenda))

                                                        <a href="javascript:void(0)" class="btn btn-warning waves-effect" data-toggle="modal" data-target="#defaultModal{{$model->id}}">Set Agenda Surat</a>

                                                        <div class="modal fade" id="defaultModal{{$model->id}}" tabindex="-1" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="defaultModalLabel">Agenda Surat</h4>
                                                                    </div>
                                                                    <form id="form_validation" method="POST" onsubmit="no_agenda.value = indeks.value + '/' + kode.value + '/' + index.value" action="{{route('pegawai.surat-keluar.set-agenda')}}" enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                            {{csrf_field()}}
                                                                            <input type="hidden" name="id" value="{{$model->id}}">
                                                                            <input type="hidden" name="no_agenda" value="">
                                                                            <div class="row clearfix">
                                                                                <div class="col-sm-12" style="margin-bottom:0;">
                                                                                    <label>No. Agenda</label>
                                                                                </div>
                                                                                <div class="col-sm-5 col-md-2" style="margin-bottom:0;">
                                                                                    <div class="form-group form-float" style="margin-bottom:0;">
                                                                                        <div class="form-line">
                                                                                            <input type="text" name="indeks" class="form-control" required value="">
                                                                                            <label class="form-label">Index</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="margin-bottom:0;float:left;">
                                                                                    <div style="margin:10px;">
                                                                                    /
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-5 col-md-2" style="margin-bottom:0;">
                                                                                    <div class="form-group form-float" style="margin-bottom:0;">
                                                                                        <div class="form-line">
                                                                                            <input type="text" name="kode" class="form-control" required value="">
                                                                                            <label class="form-label">Kode</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="margin-bottom:0;float:left;">
                                                                                    <div style="margin:10px;">
                                                                                    /
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6 col-md-2" style="margin-bottom:0;">
                                                                                    <div class="form-group form-float" style="margin-bottom:0;">
                                                                                        <div class="form-line">
                                                                                            <input type="text" name="index" class="form-control" required>
                                                                                            <label class="form-label">No Urut</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-float">
                                                                                <br>
                                                                                <label>File Surat (yang sudah ditanda tangani)</label>
                                                                                <input type="file" name="file_surat" class="form-control" style="height: auto;">
                                                                                @if ($errors->has('file_surat'))
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $errors->first('file_surat') }}</strong>
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                            <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        Perihal: {{$model->perihal}}<br>
                                                        {{$model->keterangan}}<br>
                                                    </td>
                                                    <td>{{$model->tanggal->format('j F Y')}}</td>
                                                    <td>{{$model->employee->nama}}</td>
                                                    <td>{{$model->tujuan}}</td>
                                                    <td>
                                                        <a href="{{route('pegawai.surat-keluar.show',$model->id)}}" target="_blank" class="btn btn-info waves-effect">
                                                            <i class="material-icons">visibility</i>
                                                            
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Tabs With Icon Title -->
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

function acceptAlert(id)
{
    swal({
        title: 'Apakah anda yakin akan menyetujui surat ini?',
        text: "Perubahan tidak dapat dikembalikan!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        confirmCancelText: 'Batal!'
    },function (isConfirm) {
        if (isConfirm) {
            $("#form-acc-"+id).submit()
        }
    });
}
</script>
@endsection