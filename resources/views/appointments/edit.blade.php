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


     @include('blocks.error_block')  
    {!! Form::model($appointment, ['method' => 'PATCH','route'=>['appointments.update',$appointment->apo_id]]) !!}

<div class="row">
<div class="col-sm-12">

    <div class="form-group" style="margin-bottom:4%">
        {!! Form::label($dictionary['apo_add_datetime'], $dictionary['apo_add_datetime']) !!}
        <div class="date-and-time">
        <input type="text" class="form-control datepicker" name="apo_date" data-format="D, dd MM yyyy" value="{{ $appointment->apo_date }}">
        <input value="{{ $appointment->apo_time }}" type="text" class="form-control timepicker" name="apo_time" data-template="dropdown" data-show-seconds="true" data-default-time="" data-show-meridian="true" data-minute-step="5" data-second-step="5" />
        </div>
    </div>

    <div class="form-group">
        {!! Form::label($dictionary['apo_add_subject'], $dictionary['apo_add_subject']) !!}
        {!! Form::text('apo_subject',$appointment->apo_subject,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label($dictionary['apo_add_description'], $dictionary['apo_add_description']) !!}
        {!! Form::textarea('apo_description',$appointment->apo_description,['class'=>'form-control','rows'=>'4']) !!}
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
    <a href="{{ url('appointments')}}" class="btn btn-purple">{{ $dictionary['apo_add_back'] }}</a> 
        {!! Form::submit($dictionary['apo_update_save'], ['class' => 'btn btn-info btn-single pull-right']) !!}
	{!! Form::reset($dictionary['apo_update_reset'], ['class' => 'btn btn-orange btn-single pull-right']) !!}
        
    </div>
</div>
</div>
    {!! Form::close() !!}

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


</div>
</div>
</div>
</div>

@stop
