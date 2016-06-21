@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    {!! Form::open(['url' => 'keyword-translations']) !!}
             @include('blocks.error_block')
    <div class="form-group">
        {!! Form::label('Keyword', 'Keyword:') !!}
        {!! Form::select('kwtrans_keyword_id', $keywords_array, 'kwtrans_keyword_id',['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language Code', 'Language Code:') !!}
        {!! Form::select('kwtrans_language_code', $languages_array, 'kwtrans_language_code', ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
		{!! Form::label('Word', 'Word:') !!}
		{!! Form::text('kwtrans_word',null,['class' => 'form-control']) !!}
	</div>    
    <div class="form-group">
        <a href="{{ url('keyword-translations')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single pull-right']) !!}

        
    </div>
    {!! Form::close() !!}


</div>
</div>
</div>
</div>

@stop
