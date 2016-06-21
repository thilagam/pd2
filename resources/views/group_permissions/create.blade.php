@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    {!! Form::open(['url' => 'group-permissions']) !!}
     @include("blocks.error_block")
    <div class="form-group">
        {!! Form::label('Permission Keyword', 'Permission Keyword:') !!}
        {!! Form::select('gp_perm_id',$permissions,null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Group Name', 'Group Name:') !!}
        {!! Form::select('gp_group_id',$groups,null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Permission', 'Permission:') !!}
        {!! Form::select('gp_permission', array('1' => 'Allow', '0' => 'Deny'),null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('group-permissions')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single  pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}
    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
