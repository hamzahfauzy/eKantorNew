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
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Edit Data Surat Masuk</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('pegawai.surat-masuk.update')}}" enctype="multipart/form-data">
                            	@csrf
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id" value="{{$surat->id}}">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="no_agenda" required value="{{old('no_agenda') ? old('no_agenda') : $surat->no_agenda}}">
                                        <label class="form-label">No. Agenda</label>
                                    </div>
                                    @error('no_agenda')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="no_surat" required value="{{old('no_surat') ? old('no_surat') : $surat->no_surat}}">
                                        <label class="form-label">No. Surat</label>
                                    </div>
                                    @error('no_surat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Tanggal Surat</label>
                                        <input type="text" class="datepicker form-control" name="tanggal_surat" placeholder="Tanggal Surat" required="" value="{{old('tanggal_surat') ? old('tanggal_surat') : $surat->tanggal_surat->format('Y-m-d')}}">
                                    </div>
                                    @error('tanggal_surat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Tanggal Terima</label>
                                        <input type="text" class="datepicker form-control" name="tanggal_terima" placeholder="Tanggal Terima" required="" value="{{old('tanggal_terima') ? old('tanggal_terima') : $surat->tanggal_terima->format('Y-m-d')}}">
                                    </div>
                                    @error('tanggal_terima')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="sumber_surat" required value="{{old('sumber_surat') ? old('sumber_surat') : $surat->sumber_surat}}">
                                        <label class="form-label">Sumber Surat</label>
                                    </div>
                                    @error('sumber_surat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="perihal" required value="{{old('perihal') ? old('perihal') : $surat->perihal}}">
                                        <label class="form-label">Perihal</label>
                                    </div>
                                    @error('perihal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea class="form-control" name="keterangan" required>{{old('keterangan') ? old('keterangan') : $surat->keterangan}}</textarea>
                                        <label class="form-label">Keterangan</label>
                                    </div>
                                    @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group form-float">
                                    <label>File Surat (*Kosongkan jika tidak diubah)</label>
                                    <br>
                                    <a href="{{Storage::url($surat->file_url_surat)}}">Lihat Surat</a>
                                    <input type="file" name="file_surat" class="form-control" style="height: auto;">
                                    @error('file_surat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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