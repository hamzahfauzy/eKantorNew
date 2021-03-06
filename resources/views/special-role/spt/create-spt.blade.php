@extends('bsbmtemplate.admin-template')
@section('spt-sppd-active','active')
@section('spt-active','active')
@section('content')
		<div class="container-fluid">
            <div class="block-header">
                <h2>
                    Data SPT
                </h2>
            </div>
            <!-- Basic Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Tambah SPT</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST" action="{{route('pegawai.spt.insert')}}">
                            	{{csrf_field()}}
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="no_spt" required="" data-live-search="true">
                                        <option value="">Pilih SPT</option>
                                        @foreach($spt as $model)
                                        @if($model->list) continue @endif
                                        <option value="{{$model->no_spt}}" {{old('no_spt') == $model->no_spt ? 'selected=""' : '' }}>{{$model->no_spt}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('no_spt'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('no_spt') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="wilayah_id" required="" data-live-search="true">
                                        <option value="">Pilih Wilayah Tujuan</option>
                                        @foreach($wilayah as $model)
                                        <option value="{{$model->id}}" {{old('wilayah_id') == $model->id ? 'selected=""' : '' }}>{{$model->kode}}. {{$model->keterangan}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('wilayah_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('wilayah_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <select class="form-control show-tick" name="pimpinan_id" required="" data-live-search="true">
                                        <option value="">Yang Menugaskan</option>
                                        @foreach($employees as $model)
                                        <option value="{{$model->id}}" {{old('pimpinan_id') == $model->id ? 'selected=""' : '' }}>{{$model->nama}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('wilayah_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('wilayah_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Tanggal</label>
                                        <input type="text" class="datepicker form-control" name="tanggal" placeholder="Tanggal" required="" value="{{old('tanggal')}}">
                                    </div>
                                    @if ($errors->has('tanggal'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="lama_waktu" required value="{{old('lama_waktu')}}">
                                        <label class="form-label">Selama (Hari)</label>
                                    </div>
                                    @if ($errors->has('lama_waktu'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lama_waktu') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Terhitung Sejak</label>
                                        <input type="text" class="datepicker form-control" name="tanggal_awal" placeholder="Terhitung Sejak" required="" value="{{old('tanggal_awal')}}">
                                    </div>
                                    @if ($errors->has('tanggal_awal'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_awal') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <label>Sampai Tanggal</label>
                                        <input type="text" class="form-control" name="tanggal_akhir" placeholder="Sampai" value="{{old('tanggal_akhir')}}" readonly="">
                                    </div>
                                    @if ($errors->has('tanggal_akhir'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="tempat_tujuan" required value="{{old('tempat_tujuan')}}">
                                        <label class="form-label">Tempat Tujuan</label>
                                    </div>
                                    @if ($errors->has('tempat_tujuan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tempat_tujuan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea class="form-control" name="maksud_tujuan" required>{{old('maksud_tujuan')}}</textarea>
                                        <label class="form-label">Maksud Tujuan</label>
                                    </div>
                                    @if ($errors->has('maksud_tujuan'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('maksud_tujuan') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea class="form-control" name="dasar1" required>{{old('dasar1')}}</textarea>
                                        <label class="form-label">Dasar 1</label>
                                    </div>
                                    @if ($errors->has('dasar1'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('dasar1') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea class="form-control" name="dasar2" required>{{old('dasar2')}}</textarea>
                                        <label class="form-label">Dasar 2</label>
                                    </div>
                                    @if ($errors->has('dasar2'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('dasar2') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea class="form-control" name="dasar3" required>{{old('dasar3')}}</textarea>
                                        <label class="form-label">Dasar 3</label>
                                    </div>
                                    @if ($errors->has('dasar3'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('dasar3') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                                <a class="btn btn-warning waves-effect" href="{{url()->previous()}}">KEMBALI</a>
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
$('input[name=tanggal]').bootstrapMaterialDatePicker({
    clearButton: true,
    weekStart: 1,
    time: false
});
$('input[name=tanggal_awal]').bootstrapMaterialDatePicker({
    clearButton: true,
    weekStart: 1,
    time: false
}).on('change',(e, date) => {
    var lama = $('input[name=lama_waktu]').val()
    lama = lama - 1
    $('input[name=tanggal_akhir]').val(moment(date).add(lama, 'day').format('YYYY-MM-DD'));
});

</script>
@endsection