@extends('../app')
@section('content')
    
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    {!! Form::open(['url' => 'keywords']) !!}
        @include('blocks.error_block')
    <div class="form-group">
        {!! Form::label('Name', 'Name:') !!}
        {!! Form::text('kw_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Module', 'Module:') !!}
        {!! Form::select('kw_module_id', $modules_array, 'kw_module_id',['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('keywords')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single  pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}

    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>
    
@stop
