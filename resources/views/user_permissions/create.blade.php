@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    {!! Form::open(['url' => 'user-permissions']) !!}
         @include("blocks.error_block")
    <div class="form-group">
        {!! Form::label('User', 'User:') !!}
        {!! Form::select('uperm_user_id',$users,null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Enabled Perm', 'Enabled Perm:') !!}
        {!! Form::select('uperm_enabled[]',$permissions,null,['class'=>'form-control','multiple'])  !!}
    </div>
    <div class="form-group">
        {!! Form::label('Disbaled Perm','Disbaled Perm:') !!}
        {!! Form::select('uperm_disabled[]',$permissions,null,['class'=>'form-control','multiple']) !!}
    </div>	
    <div class="form-group">
        <a href="{{ url('user-permissions')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single  pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}


    </div>
    {!! Form::close() !!}


</div>
</div>
</div>
</div>

@stop
