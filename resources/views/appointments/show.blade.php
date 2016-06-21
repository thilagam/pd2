@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

								<style type="text/css">
									.myFile {
											  position: relative;
											  overflow: hidden;
											  float: left;
											  clear: left;
											}
											.myFile input[type="file"] {
											  display: block;
											  position: absolute;
											  top: 0;
											  right: 0;
											  opacity: 0;
											  font-size: 100px;
											  filter: alpha(opacity=0);
											  cursor: pointer;
											}
								</style>


<div class="row">
<div class="col-sm-12">
    <div class="form-group" style="margin-bottom:4%">
        {!! Form::label($dictionary['apo_add_datetime'], $dictionary['apo_add_datetime']) !!}
        <div class="date-and-time">
        <input readonly type="text" class="form-control datepicker" name="apo_date" data-format="D, dd MM yyyy" placeholder="{{ $appointment->apo_date }}">
        <input placeholder="{{ $appointment->apo_time }}" readonly type="text" class="form-control timepicker" name="apo_time" data-template="dropdown" data-show-seconds="true" data-default-time="" data-show-meridian="true" data-minute-step="5" data-second-step="5" />
        </div>
    </div>


        <div class="form-group">
            <label for="Language Name">{{ $dictionary['apo_add_subject'] }}</label>

<input type="text" class="form-control" placeholder="{{ $appointment->apo_subject }}" readonly>

        </div>
        <div class="form-group">
            <label for="Language Code">{{ $dictionary['apo_add_description'] }}</label>

                <textarea type="text" class="form-control" placeholder="{{ $appointment->apo_description }}" readonly></textarea>

        </div>

@if($appointment['apo_attachement_id'] > 0)
<div class="form-group">
<!-- <label class="col-sm-2 control-label" for="field-1">Template</label> -->
{!! Form::label($dictionary['apo_add_attachment'],$dictionary['apo_add_attachment']) !!}


@foreach($attachments as $att)
<div style="padding:1% 0%">

<a href="/download/{{ Crypt::encrypt($att->attfiles_path) }}/s"><i class="fa fa-download" style="padding-right:2%"></i> <span>  {{ $att->attfiles_original_name }}</span></a>

</div>
@endforeach

</div>
@endif

</div>

<div class="col-sm-12" style="margin-top:2%">

        <div class="form-group">

        @if($permit->module_client_appointments_edit)
		<a href="{{ url('/appointments/'.$appointment->apo_id.'/edit')}}" class="btn btn-blue pull-right" style="margin-right:2%;margin-left:2%">{{ $dictionary['apo_show_edit'] }}</a>
        @endif

        @if($permit->module_client_appointments_delete)
             {!! Form::open(['method' => 'DELETE', 'route'=>['appointments.destroy', $appointment->apo_id]]) !!}
             {!! Form::submit($dictionary['apo_show_delete'], ['class' => 'btn btn-danger pull-right', 'onclick' => 'return confirm("'.$dictionary['delete_confirm_alert'].'");']) !!}
             {!! Form::close() !!}
        @endif

                <a href="{{ url('appointments')}}" class="btn btn-purple ">{{ $dictionary['apo_add_back'] }}</a>


        </div>
</div>
</div>

</div>
</div>
</div>
</div>


<link rel="stylesheet" href="{{ asset('/assets/js/daterangepicker/daterangepicker-bs3.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2-bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/multiselect/css/multi-select.css') }}">
<!-- Imported scripts on this page -->
<script src="{{ asset('/assets/js/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>
<script src="{{ asset('/assets/js/tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('/assets/js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('/assets/js/handlebars.min.js') }}"></script>
<script src="{{ asset('/assets/js/multiselect/js/jquery.multi-select.js') }}"></script>

<!-- Date Timer Picker -->
<script src="{{ asset('assets/js/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/js/timepicker/bootstrap-timepicker.min.js') }}"></script>


@stop
