@extends('../app')
@section('content')
    <h4>Add</h4>
	@if (count($errors) > 0)
	<div class="alert alert-danger">
	<strong>Whoops!</strong> There were some problems with your input.<br><br>
	<ul>
	@foreach ($errors->all() as $error)
	   <li>{{ $error }}</li>
	@endforeach
	</ul>
	</div>
	@endif	

    {!! Form::open(['url' => 'languages']) !!}
    <div class="form-group">
        {!! Form::label('Language Code', 'Language Code:') !!}
        {!! Form::text('lang_code',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language Name', 'Language Name:') !!}
        {!! Form::text('lang_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single']) !!}
	{!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single']) !!}
        <a href="{{ url('languages')}}" class="btn btn-purple pull-right">Back</a> 
    </div>
    {!! Form::close() !!}
@stop
