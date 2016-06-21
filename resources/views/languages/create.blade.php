@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

      @include('blocks.error_block')
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
        <a href="{{ url('languages')}}" class="btn btn-purple">Back</a> 
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single  pull-right']) !!}
	    {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}

    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
