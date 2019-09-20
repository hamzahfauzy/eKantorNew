@extends('bsbmtemplate.admin-template')
@section('agenda-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data Agenda
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Tambah Data Agenda</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('agenda.insert')}}">
                            	{{csrf_field()}}
                                <div class="form-group form-float">
                                    <label>Agenda Untuk </label>
                                    <select class="form-control show-tick" name="employee_for_id" required="" data-live-search="true">
                                        <option value="{{auth()->user()->employee->id}}">Untuk Saya Sendiri</option>
                                        @foreach($atasan as $model)
                                        <option value="{{$model->id}}" {{old('employee_for_id') == $model->id ? 'selected=""' : '' }}>{{$model->nama}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('employee_for_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('employee_for_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Tanggal Mulai</label>
                                        <input type="text" class="datepicker date form-control" name="tanggal_awal" placeholder="Tanggal Mulai" required="" value="{{old('tanggal_awal')}}">
                                    </div>
                                    @if ($errors->has('tanggal_awal'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_awal') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Tanggal Selesai</label>
                                        <input type="text" class="datepicker date form-control" name="tanggal_akhir" placeholder="Tanggal Selesai" required="" value="{{old('tanggal_akhir')}}">
                                    </div>
                                    @if ($errors->has('tanggal_akhir'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Waktu Mulai</label>
                                        <input type="text" class="datepicker time form-control" name="waktu_mulai" placeholder="Waktu Mulai" value="{{old('waktu_mulai')}}">
                                    </div>
                                    @if ($errors->has('waktu_mulai'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('waktu_mulai') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Waktu Selesai</label>
                                        <input type="text" class="datepicker time form-control" name="waktu_selesai" placeholder="Waktu Selesai" value="{{old('waktu_selesai')}}">
                                    </div>
                                    @if ($errors->has('waktu_selesai'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('waktu_selesai') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="kegiatan" required value="{{old('kegiatan')}}">
                                        <label class="form-label">Kegiatan</label>
                                    </div>
                                    @if ($errors->has('kegiatan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('kegiatan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="tempat" required value="{{old('tempat')}}">
                                        <label class="form-label">Tempat</label>
                                    </div>
                                    @if ($errors->has('tempat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tempat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="keterangan" required value="{{old('keterangan')}}">
                                        <label class="form-label">keterangan</label>
                                    </div>
                                    @if ($errors->has('keterangan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('keterangan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <label>File Terkait</label>
                                    <input type="file" name="file_url" class="form-control" style="height: auto;">
                                    @if ($errors->has('file_url'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('file_url') }}</strong>
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
$('input.datepicker.date').bootstrapMaterialDatePicker({
    clearButton: true,
    weekStart: 1,
    time: false
});

$('input.datepicker.time').bootstrapMaterialDatePicker({
    clearButton: true,
    weekStart: 1,
    date:false,
    format:'HH:mm',
    time: true
});
</script>
@endsection