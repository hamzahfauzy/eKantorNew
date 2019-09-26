@extends('bsbmtemplate.admin-template')
@section('surat-active','active')
@section('surat-keputusan-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Surat Keputusan
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Tambah Data Surat Keputusan</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('pegawai.surat-keputusan.insert')}}" enctype="multipart/form-data">
                            	{{csrf_field()}}
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="no_surat" required value="{{old('no_surat')}}">
                                        <label class="form-label">No. SK</label>
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
                                        <input type="text" class="form-control" name="tentang" required value="{{old('tentang')}}">
                                        <label class="form-label">Tentang</label>
                                    </div>
                                    @if ($errors->has('tentang'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tentang') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="tahun" required value="{{old('tahun')}}">
                                        <label class="form-label">Tahun</label>
                                    </div>
                                    @if ($errors->has('tahun'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tahun') }}</strong>
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