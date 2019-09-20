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

                                    <div class="col-12">
                                        <label>Jumlah Lampiran:</label><br>
                                        <p>{{$surat->jumlah_lampiran}} {{$surat->satuan_lampiran}}</p>
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
                                <div class="row">
                                    <div class="col-12">
                                        @if(env('APP_ENV') == 'local')
                                        <iframe src="{{Storage::url($surat->file_url_surat)}}" style="width: 100%;height: 500px;" frameborder="0"></iframe>
                                        @else
                                        <iframe src="http://docs.google.com/viewer?url={{Storage::url($surat->file_url_surat)}}&embedded=true" style="width: 100%;height: 500px;" frameborder="0"></iframe>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header">
                            <!-- <a href="{{Storage::url($surat->file_url_surat)}}" class="btn btn-success waves-effect">
                                <i class="material-icons">visibility</i>
                                <span>Lihat Surat</span>
                            </a> -->
                            @if((empty($surat->disposisis) || count($surat->disposisis) == 0) && (auth()->user()->employee->isPimpinan() || auth()->user()->employee->kepala_group_special_role()) )
                            <a href="javascript:void(0)" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#defaultModal">
                                <i class="material-icons">arrow_forward</i>
                                <span>Disposisi</span>
                            </a>
                            @endif

                            @if(count($surat->disposisis) > 0 && auth()->user()->employee->inSpecialRoleUser())
                            <a href="{{route('pegawai.surat-masuk.print',$surat->id)}}" class="btn btn-warning waves-effect">
                                <i class="material-icons">print</i>
                                <span>Cetak Lembar Disposisi</span>
                            </a>
                            @endif

                            @if(empty($surat->status_teruskan) && auth()->user()->employee->kepala_group_special_role() && count($surat->disposisis) == 0)
                            <a href="{{route('pegawai.surat-masuk.teruskan')}}" class="btn btn-danger waves-effect" onclick="event.preventDefault();teruskanAlert({{$surat->id}})">
                                <i class="material-icons">arrow_forward</i>
                                <span>Teruskan</span>
                            </a>

                            <form id="form-teruskan-{{$surat->id}}" style="display: none;" method="post" action="{{route('pegawai.surat-masuk.teruskan')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$surat->id}}">
                            </form>
                            @endif

                            @if(!empty($surat->lampiran) && count($surat->lampiran) > 0)
                            <div>
                                <br>
                                <span>Lampiran</span>
                                <ul>
                                    @foreach($surat->lampiran as $key => $lampiran)
                                    <li><a href="{{Storage::url($lampiran->file_lampiran_url)}}" target="_blank">Lampiran {{$key+1}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
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

                                    @if(count($surat->histori) == 0 || $surat->histori[0]->status != 'Surat Masuk')
                                    <div class="col-12">
                                        <label>{{$surat->created_at->format('j F Y H:i:s')}}</label><br>
                                        <p>Surat Masuk</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Set Disposisi Surat</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form_validation" method="POST" action="{{route('sekretaris.surat.set-disposisi',$surat->id)}}">
                                {{csrf_field()}}
                                <div class="form-group form-float">
                                    <label>Disposisikan Ke:</label>
                                    <select class="form-control show-tick" name="pegawai[]" required="" data-live-search="true" multiple="">
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->nama}} ({{$employee->jabatan}})</option>
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
            <!-- #END# Basic Examples -->
        </div>
@endsection

@section('script')
<!-- Sweet Alert Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
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