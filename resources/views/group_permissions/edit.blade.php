@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    {!! Form::model($group_permission,['method' => 'PATCH','route'=>['group-permissions.update',$group_permission->gp_id]]) !!}
     @include("blocks.error_block")
    <div class="form-group">
        {!! Form::label('Permission Keyword', 'Permission Keyword:') !!}
        {!! Form::select('gp_perm_id',$permissions,$group_permission->gp_perm_id,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Group Name', 'Group Name:') !!}
        {!! Form::select('gp_group_id',$groups,$group_permission->gp_group_id,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
{!! Form::label('Permission', 'Permission:') !!}                              
{!! Form::select('gp_permission', array('1' => 'Allow', '0' => 'Deny'), $group_permission->gp_permission, ['class'=>'form-control'])!!}                            </div> 
     <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!}
        {!! Form::select('gp_status', array('1' => 'Active', '0' => 'In-Active'), $group_permission->gp_status, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('group-permissions')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Update', ['class' => 'btn btn-info btn-single  pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}

    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
