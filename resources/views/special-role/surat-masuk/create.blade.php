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
                            <h2>Tambah Data Surat Masuk</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" onsubmit="no_agenda.value = indeks.value + '/' + kode.value + '/' + index.value" action="{{route('pegawai.surat-masuk.insert')}}" enctype="multipart/form-data">
                            	{{csrf_field()}}
                                <input type="hidden" name="no_agenda">
                                <div class="row clearfix">
                                    <div class="col-sm-12" style="margin-bottom:0;">
                                        <label>No. Agenda</label>
                                    </div>
                                    <div class="col-sm-5 col-md-2" style="margin-bottom:0;">
                                        <div class="form-group form-float" style="margin-bottom:0;">
                                            <div class="form-line">
                                                <input type="text" name="indeks" class="form-control" required>
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
                                                <input type="text" name="kode" class="form-control" required>
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
                                    <div class="col-sm-12">
                                    @if ($errors->has('no_agenda'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('no_agenda') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="no_surat" required value="{{old('no_surat')}}">
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
                                        <input type="text" class="datepicker form-control" name="tanggal_surat" placeholder="Tanggal Surat" required="" value="{{old('tanggal_surat')}}">
                                    </div>
                                    @if ($errors->has('tanggal_surat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_surat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Tanggal Terima</label>
                                        <input type="text" class="datepicker form-control" name="tanggal_terima" placeholder="Tanggal Terima" required="" value="{{old('tanggal_terima')}}">
                                    </div>
                                    @if ($errors->has('tanggal_terima'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_terima') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="sumber_surat" required value="{{old('sumber_surat')}}">
                                        <label class="form-label">Sumber Surat</label>
                                    </div>
                                    @if ($errors->has('sumber_surat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('sumber_surat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="sifat_surat" required value="{{old('sifat_surat')}}">
                                        <label class="form-label">Sifat Surat</label>
                                    </div>
                                    @if ($errors->has('sifat_surat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('sifat_surat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="perihal" required value="{{old('perihal')}}">
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
                                        <textarea class="form-control" name="keterangan" required>{{old('keterangan')}}</textarea>
                                        <label class="form-label">Keterangan</label>
                                    </div>
                                    @if ($errors->has('keterangan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('keterangan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="jumlah_lampiran" required value="{{old('jumlah_lampiran')}}">
                                        <label class="form-label">Jumlah Lampiran</label>
                                    </div>
                                    @if ($errors->has('jumlah_lampiran'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('jumlah_lampiran') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="satuan_lampiran" required value="{{old('satuan_lampiran')}}">
                                        <label class="form-label">Satuan Lampiran</label>
                                    </div>
                                    @if ($errors->has('satuan_lampiran'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('satuan_lampiran') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <label>File Surat</label>
                                    <input type="file" name="file_surat" class="form-control" style="height: auto;">
                                    @if ($errors->has('file_surat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('file_surat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <label>File Lampiran (Multiple File)</label>
                                    <input type="file" name="file_lampiran[]" class="form-control" style="height: auto;" multiple="">
                                    @if ($errors->has('file_lampiran'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('file_lampiran') }}</strong>
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