@extends('../app')
@section('content')


<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">

     @include('blocks.error_block')  
    {!! Form::model($breadcrumb,['method' => 'PATCH','route'=>['breadcrumbs.update',$breadcrumb->breadcrumb_id]]) !!}
    <div class="form-group">
        {!! Form::label('Modules', 'Modules') !!}
        {!! Form::select('breadcrumb_module_id',$modules_l,$breadcrumb->breadcrumb_module_id,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Name', 'Name:') !!}
        {!! Form::text('breadcrumb_name',$breadcrumb->breadcrumb_name,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Description', 'Description:') !!}
        {!! Form::text('breadcrumb_description',$breadcrumb->breadcrumb_description,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Page Title', 'Page Tile:') !!}
        {!! Form::text('breadcrumb_page_title',$breadcrumb->breadcrumb_page_title,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Url', 'Url:') !!}
        {!! Form::text('breadcrumb_url',$breadcrumb->breadcrumb_url,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!}
        {!! Form::select('breadcrum_status', array('1' => 'Active', '0' => 'In-Active'), $breadcrumb->breadcrumb_status, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('breadcrumbs')}}" class="btn btn-purple ">Back</a> 
        {!! Form::submit('Update', ['class' => 'btn btn-info btn-single pull-right']) !!}
	    {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single pull-right']) !!}
    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
@stop
