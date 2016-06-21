@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

     @include('blocks.error_block')  
    {!! Form::model($act_templates_i,['method' => 'PATCH','route'=>['activity-templates.update',$act_templates_i->actmpplus_id]]) !!}
    <div class="form-group">
        {!! Form::label('Template Name', 'Template Name') !!}
        {!! Form::select('actmpplus_template_id',$act_templates,$act_templates_i->actmpplus_template_id,['class'=>'form-control template-class']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language', 'Language') !!}
        {!! Form::select('actmpplus_language_code',$languages,$act_templates_i->actmpplus_language_code,['class'=>'form-control module-class']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Type', 'Type') !!}
        {!! Form::select('actmpplus_type',$act_templates_type,$act_templates_i->actmpplus_type,['class'=>'form-control module-class']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Text', 'Text') !!}
        <textarea name="actmpplus_template" class="form-control" rows="4">{{ $act_templates_i->actmpplus_template }}</textarea>
    </div>
    <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!} 
        {!! Form::select('actmpplus_status', array('1' => 'Active', '0' => 'In-Active'), $act_templates_i->actmpplus_status, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single']) !!}
        <a href="{{ url('activity-templates')}}" class="btn btn-purple pull-right">Back</a> 
    </div>
    {!! Form::close() !!}


</div>
</div>
</div>
</div>

@stop
