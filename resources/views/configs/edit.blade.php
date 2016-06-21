@extends('../app')
@section('content')

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">

    {!! Form::model($config,['method' => 'PATCH','route'=>['configs.update',$config->conf_id]]) !!}
	@include("blocks.error_block")	
    <div class="form-group">
        {!! Form::label('Name', 'Name:') !!}
        {!! Form::text('conf_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Value', 'Value:') !!}
        {!! Form::text('conf_value',null,['class'=>'form-control']) !!}
    </div>
        <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!}
        {!! Form::select('conf_status', array('1' => 'Active', '0' => 'In-Active'), $config->conf_status, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('configs')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Update', ['class' => 'btn btn-info btn-single  pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}

    </div>
    {!! Form::close() !!}

</div>
</div>
</div>    
@stop
