@extends('../app')
@section('content')

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">

    {!! Form::open(['url' => 'configs']) !!}
    @include('blocks.error_block')
    <div class="form-group">
        {!! Form::label('Variable Name', 'Varibale Name:') !!}
        {!! Form::text('conf_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Variable Value', 'Variable Value:') !!}
        {!! Form::text('conf_value',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
         <a href="{{ url('configs')}}" class="btn btn-purple ">Back</a>
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single pull-right']) !!}

    </div>
</div>
</div>
</div>
    {!! Form::close() !!}
@stop
