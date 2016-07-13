@extends('../app')
@section('content')

<div class="col-sm-12">
<div class="panel panel-default">
    <div class="panel-body">

    <h4>Add</h4>
      @include('blocks.error_block')
     {!! Form::open(['url' => 'breadcrumbs']) !!}
    <div class="form-group">
        {!! Form::label('Modules', 'Modules') !!}
        {!! Form::select('breadcrumb_module_id',array(''=>'Select')+$modules,null,['class'=>'form-control module-class']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Name', 'Name:') !!}
        {!! Form::text('breadcrumb_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Description', 'Description:') !!}
        {!! Form::text('breadcrumb_description',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Page Title', 'Page Tile:') !!}
        {!! Form::text('breadcrumb_page_title',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Url', 'Url:') !!}
        {!! Form::text('breadcrumb_url',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('breadcrumbs')}}" class="btn btn-purple">Back</a> 
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single  pull-right']) !!}
	    {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}

    </div>
    {!! Form::close() !!}

    </div>
</div>
</div>

@stop






