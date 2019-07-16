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
                                {{$surat->perihal}}
                            </h2>
                            <div class="pull-right">
                                <span>
                                    <i class="material-icons" style="font-size: 14px">person</i>
                                    <a href="javascript:void(0)">{{$surat->employee->nama}}</a> | {{$surat->created_at->format('j F Y')}}
                                </span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Tanggal Terima / No Agenda:</label><br>
                                        <p>{{$surat->tanggal_terima->format('j F Y')}} | {{$surat->no_agenda}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Dari:</label><br>
                                        <p>{{$surat->sumber_surat}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Tanggal Surat / No Surat:</label><br>
                                        <p>{{$surat->tanggal_surat->format('j F Y')}} | {{$surat->no_surat}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Perihal:</label><br>
                                        <p>{{$surat->perihal}}</p>
                                    </div>

                                    <div class="col-12">
                                        <label>Keterangan:</label><br>
                                        <p>{{$surat->keterangan}}</p>
                                    </div>

                                    @if(!empty($surat->disposisis) && count($surat->disposisis) > 0)
                                    <div class="col-12">
                                        <label>Di Disposisikan Ke:</label><br>
                                        <ul>
                                        @foreach($surat->disposisis as $disposisi)
                                        <li>{{$disposisi->employee->nama}} ({{$disposisi->employee->kepala_group ? $disposisi->employee->kepala_group->nama : ($disposisi->employee->kepala_sub_group ? $disposisi->employee->kepala_sub_group->nama : ($disposisi->employee->staffGroup ? $disposisi->employee->staffGroup->subGroups->nama : ''))}})</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="header">
                            <a href="{{Storage::url($surat->file_url_surat)}}" class="btn btn-success waves-effect">
                                <i class="material-icons">visibility</i>
                                <span>Lihat Surat</span>
                            </a>
                            @if((empty($surat->disposisis) || count($surat->disposisis) == 0) && auth()->user()->employee->isPimpinan())
                            <a href="javascript:void(0)" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#defaultModal">
                                <i class="material-icons">arrow_forward</i>
                                <span>Disposisi</span>
                            </a>
                            @endif

                            @if($surat->disposisis && auth()->user()->employee->inSpecialRoleUser())
                            <a href="#cetak_dispoissi" class="btn btn-warning waves-effect">
                                <i class="material-icons">print</i>
                                <span>Cetak Lembar Disposisi</span>
                            </a>
                            @endif

                            @if(empty($surat->status_teruskan) && auth()->user()->employee->kepala_group_special_role())
                            <a href="{{route('pegawai.surat-masuk.teruskan')}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();teruskanAlert({{$surat->id}})">
                                <i class="material-icons">arrow_forward</i>
                                <span>Teruskan</span>
                            </a>

                            <form id="form-teruskan-{{$surat->id}}" style="display: none;" method="post" action="{{route('pegawai.surat-masuk.teruskan')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$surat->id}}">
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="pull-left">
                                Histori
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="body">
                            <div class="container-fluid">
                                <div class="row">
                                    @foreach($surat->histori()->orderby('created_at','desc')->get() as $histori)
                                    <div class="col-12">
                                        <label>{{$histori->created_at->format('j F Y H:i:s')}}</label><br>
                                        <p>{{$histori->status}}</p>
                                    </div>
                                    @endforeach
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
<!-- Sweet Alert Plugin Js -->
<script src="{{asset('template/bsbm/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script type="text/javascript">

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