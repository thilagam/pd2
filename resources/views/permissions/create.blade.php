@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    {!! Form::open(['url' => 'permissions']) !!}
        @include("blocks.error_block")
    <div class="form-group">
        {!! Form::label('Permission Keyword', 'Permission Keyword:') !!}
        {!! Form::text('perm_keyword',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Permission Description', 'Permission Description:') !!}
        {!! Form::text('perm_description',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('permissions')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single  pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}

    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
