@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

     @include('blocks.error_block')  
    {!! Form::model($generalSpecs,['method' => 'PATCH','route'=>['general-specifications.update',$generalSpecs->specgen_id]]) !!}
    {!! Form::hidden('specgen_spec_id',$generalSpecs->specgen_spec_id) !!}
    <div class="form-group">
        {!! Form::label('Description', 'Description:') !!}
        {!! Form::textarea('specgen_description',$generalSpecs->specgen_description,['class'=>'form-control','rows'=>'5']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Url', 'Url:') !!}
        {!! Form::text('specgen_url',$generalSpecs->specgen_url,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language', 'Language:') !!}
        {!! Form::select('specgen_language_code',$languages_array, null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!}
        {!! Form::select('specgen_status', array('1' => 'Active', '0' => 'In-Active'), $generalSpecs->specgen_status, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('general-specifications')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Update', ['class' => 'btn btn-info btn-single  pull-right']) !!}
	{!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}
 
    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
