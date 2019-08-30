@extends('bsbmtemplate.admin-template')
@section('surat-active','active')
@section('surat-keluar-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Surat Keluar
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Edit Data Surat Keluar</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('pegawai.surat-keluar.update')}}" enctype="multipart/form-data">
                            	{{csrf_field()}}
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id" value="{{$surat->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="no_surat" required value="{{old('no_surat') ? old('no_surat') : $surat->no_surat}}">
                                        <label class="form-label">No. Surat</label>
                                    </div>
                                    @if ($errors->has('no_surat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('no_surat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Tanggal Surat</label>
                                        <input type="text" class="datepicker form-control" name="tanggal_surat" placeholder="Tanggal Surat" required="" value="{{old('tanggal_surat') ? old('tanggal_surat') : $surat->tanggal->format('Y-m-d')}}">
                                    </div>
                                    @if ($errors->has('tanggal_surat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_surat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="tujuan" required value="{{old('tujuan') ? old('tujuan') : $surat->tujuan}}">
                                        <label class="form-label">Tujuan</label>
                                    </div>
                                    @if ($errors->has('tujuan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tujuan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="perihal" required value="{{old('perihal') ? old('perihal') : $surat->perihal}}">
                                        <label class="form-label">Perihal</label>
                                    </div>
                                    @if ($errors->has('perihal'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('perihal') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea class="form-control" name="keterangan" required>{{old('keterangan') ? old('keterangan') : $surat->keterangan}}</textarea>
                                        <label class="form-label">Keterangan</label>
                                    </div>
                                    @if ($errors->has('keterangan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('keterangan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <label>File Surat (*Kosongkan jika tidak diubah)</label>
                                    <br>
                                    <a href="{{Storage::url($surat->file_surat_url)}}">Lihat Surat</a>
                                    <input type="file" name="file_surat" class="form-control" style="height: auto;">
                                    @if ($errors->has('file_surat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('file_surat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('script')
<!-- Select Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
<!-- Moment Plugin Js -->
<script src="{{asset('template/bsbm/plugins/momentjs/moment.js')}}"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script type="text/javascript">
$('input.datepicker').bootstrapMaterialDatePicker({
    clearButton: true,
    weekStart: 1,
    time: false
});
</script>
@endsection