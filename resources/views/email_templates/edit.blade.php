@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

     @include('blocks.error_block')  
    {!! Form::model($etemplate,['method' => 'PATCH','route'=>['email-templates.update',$etemplate->etempplus_id]]) !!}
    <div class="form-group">
        {!! Form::label('Template Name', 'Template Name') !!}
        {!! Form::select('etempplus_template_id',$templates_all,$etemplate->etempplus_template_id,['class'=>'form-control template-class']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language', 'Language') !!}
        {!! Form::select('etempplus_language_code',$languages,$etemplate->etempplus_language_code,['class'=>'form-control module-class']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Template Code', 'Template Code') !!}
        <textarea name="etempplus_template_code" class="form-control" rows="10" data-uk-htmleditor>{{ $etemplate->etempplus_template_code  }}</textarea>
    </div>	
    <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!}
        {!! Form::select('etempplus_status', array('1' => 'Active', '0' => 'In-Active'), $etemplate->etempplus_status, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Update', ['class' => 'btn btn-info btn-single']) !!}
	{!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single']) !!}
        <a href="{{ url('email-templates')}}" class="btn btn-purple pull-right">Back</a> 
    </div>
    {!! Form::close() !!}

	<link rel="stylesheet" href="{{ asset('/assets/js/uikit/vendor/codemirror/codemirror.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/uikit/uikit.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/uikit/css/addons/uikit.almost-flat.addons.min.css') }}">

	<!-- Imported scripts on this page -->
	<script src="{{ asset('/assets/js/uikit/vendor/codemirror/codemirror.js') }}"></script>
	<script src="{{ asset('/assets/js/uikit/vendor/marked.js') }}"></script>
	<script src="{{ asset('/assets/js/uikit/js/uikit.min.js') }}"></script>
	<script src="{{ asset('/assets/js/uikit/js/addons/htmleditor.min.js') }}"></script>

</div>
</div>
</div>
</div>

@stop
