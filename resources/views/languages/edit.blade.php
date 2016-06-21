@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

     @include('blocks.error_block')  
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
        <a href="{{ url('languages')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Update', ['class' => 'btn btn-info btn-single  pull-right']) !!}
	{!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}
 
    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
