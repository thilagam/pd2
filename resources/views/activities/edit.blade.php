@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

     @include('blocks.error_block')  
    {!! Form::model($activity_type,['method' => 'PATCH','route'=>['activity-types.update',$activity_type->acttype_id]]) !!}
    <div class="form-group">
        {!! Form::label('Name', 'Name:') !!}
        {!! Form::text('acttype_name',$activity_type->acttype_name,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Description', 'Description:') !!}
        {!! Form::textarea('acttype_description',$activity_type->acttype_description,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Icon', 'Icon:') !!} <i class="{{ $activity_type->acttype_icon }}"></i>
        {!! Form::text('acttype_icon',$activity_type->acttype_icon,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!} 
        {!! Form::select('acttype_status', array('1' => 'Active', '0' => 'In-Active'), $activity_type->acttype_status, ['class'=>'form-control']) !!}
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
