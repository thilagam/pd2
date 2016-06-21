@extends('../app')
@section('content')
    <h4>Update</h4>
    {!! Form::model($language,['method' => 'PATCH','route'=>['languages.update',$language->lang_id]]) !!}
    <div class="form-group">
        {!! Form::label('Language Name', 'Language Name:') !!}
        {!! Form::text('lang_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language Code', 'Language Code:') !!}
        {!! Form::text('lang_code',null,['class'=>'form-control']) !!}
    </div>
        <div class="form-group">
        {!! Form::label('Language Staus', 'Language Status:') !!}
        {!! Form::select('lang_status', array('1' => 'Active', '0' => 'In-Active'), $language->lang_status, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Update', ['class' => 'btn btn-info btn-single']) !!}
	{!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single']) !!}
        <a href="{{ url('languages')}}" class="btn btn-purple pull-right">Back</a> 
    </div>
    {!! Form::close() !!}
@stop
