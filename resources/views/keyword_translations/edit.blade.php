@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    {!! Form::model($keyword_translation,['method' => 'PATCH','route'=>['keyword-translations.update',$keyword_translation->kwtrans_id]]) !!}
              @include('blocks.error_block')
    <div class="form-group">
        {!! Form::label('Keyword', 'Keyword:') !!}
        {!! Form::select('kwtrans_keyword_id', $keywords_array ,$keyword_translation->kwtrans_keyword_id, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language', 'Language:') !!}
        {!! Form::select('kwtrans_language_code', $languages_array ,$keyword_translation->kwtrans_language_code, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Word', 'Word:') !!}
        {!! Form::text('kwtrans_word', null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!}
        {!! Form::select('kwtrans_status', array('1' => 'Active', '0' => 'In-Active'), $keyword_translation->kwtrans_status, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        <a href="{{ url('keyword-translations')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Update', ['class' => 'btn btn-info btn-single  pull-right']) !!}
        {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}

    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
