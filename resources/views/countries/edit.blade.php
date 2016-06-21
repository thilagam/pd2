@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    {!! Form::model($country,['method' => 'PATCH','route'=>['countries.update',$country->country_id]]) !!}
        @include('blocks.error_block')
    <div class="form-group">
        {!! Form::label('Name', 'Name:') !!}
        {!! Form::text('country_name',null,['class'=>'form-control']) !!}
    </div>
        <div class="form-group">
        {!! Form::label('Code', 'Code:') !!}
        {!! Form::text('country_code',null,['class'=>'form-control']) !!}
    </div>
    <div>
        <div class="form-group">
        {!! Form::label('ISO', 'ISO:') !!}
        {!! Form::text('country_iso',null,['class'=>'form-control']) !!}
    </div>
    <div>
        <div class="form-group">
        {!! Form::label('Currency', 'Currency:') !!}
        {!! Form::text('country_currency',null,['class'=>'form-control']) !!}
    </div>
    <div>
        <div class="form-group">
        {!! Form::label('Currency Symbol', 'Currency Symbol:') !!}
        {!! Form::text('country_currency_symbol',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language', 'Language:') !!}
        {!! Form::select('country_language_code', $languages_array ,'country_language_code',['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!}
        {!! Form::select('country_status', array('1' => 'Active', '0' => 'In-Active'),'country_status',['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('countries')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Update', ['class' => 'btn btn-info btn-single  pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}


    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
