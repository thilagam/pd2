@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

      @include('blocks.error_block')
     {!! Form::open(['url' => 'activity-types']) !!}
    <div class="form-group">
        {!! Form::label('Name', 'Name:') !!}
        {!! Form::text('acttype_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Description', 'Description:') !!}
        {!! Form::textarea('acttype_description',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Icon', 'Icon:') !!}
        {!! Form::text('acttype_icon',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single']) !!}
	    {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single']) !!}
        <a href="{{ url('activity-types')}}" class="btn btn-purple pull-right">Back</a> 
    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
