@extends('../app')
@section('content')

<div class="panel panel-default">
    <div class="panel-body">

    <h4>{{ $dictionary['gp_group_add'] }}</h4>
    {!! Form::open(['url' => 'groups']) !!}
     @include("blocks.error_block")
    <div class="form-group">
        {!! Form::label($dictionary['gp_group_name'], $dictionary['gp_group_name']) !!}
        {!! Form::text('group_name',null,['class'=>'form-control','placeholder'=>$dictionary['gp_group_name_placeholder']]) !!}
    </div>
    <div class="form-group">
        {!! Form::label($dictionary['gp_group_description'], $dictionary['gp_group_description']) !!}
        {!! Form::text('group_description',null,['class'=>'form-control','placeholder'=>$dictionary['gp_group_description_placeholder']]) !!}
    </div>
    <div class="form-group">
        {!! Form::label($dictionary['gp_group_code'], $dictionary['gp_group_code']) !!}
        {!! Form::text('group_code',null,['class'=>'form-control','placeholder'=>$dictionary['gp_group_code_placeholder']]) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('groups')}}" class="btn btn-purple">{{ $dictionary['gp_group_back'] }}</a>
        {!! Form::submit($dictionary['gp_group_save'], ['class' => 'btn btn-info btn-single pull-right']) !!}
        {!! Form::reset($dictionary['gp_group_reset'], ['class' => 'btn btn-orange btn-single pull-right']) !!}
    </div>
    {!! Form::close() !!}

    </div>
</div>

@stop
