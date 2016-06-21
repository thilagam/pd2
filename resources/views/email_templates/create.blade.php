@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

      @include('blocks.error_block')
     {!! Form::open(['url' => 'email-templates']) !!}
    <div class="form-group">
        {!! Form::label('Template', 'Template') !!}
        {!! Form::select('etempplus_template_id',$templates_all,null,['class'=>'form-control template-class']) !!}
        <p class="help-block">Keep Above field Blank to Add New Email Template </p>
    </div>
    <div id="template_details">
    <div class="form-group">
        {!! Form::label('Name', 'Name:') !!}
        {!! Form::text('etemp_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Description', 'Description:') !!}
        {!! Form::text('etemp_description',null,['class'=>'form-control']) !!}
    </div>
    </div>
    <div class="form-group">
        {!! Form::label('Language', 'Language') !!}
        {!! Form::select('etempplus_language_code',$languages,null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Template', 'Template') !!}
        <textarea name="etempplus_template_code" class="form-control" rows="10" data-uk-htmleditor><h1>Heading</h1></textarea>
    </div>

    <div class="form-group">
        <a href="{{ url('languages')}}" class="btn btn-purple">Back</a>
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single pull-right']) !!}
	{!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single pull-right']) !!}
    </div>
    {!! Form::close() !!}


                                <script type="text/javascript">
                                    jQuery(document).ready(function($)
                                    {
                                        $(".template-class").change(function () {
                                            var bool=$(this).val();
                                            alert(bool);
                                            if(bool == 0)
                                            {
                                                // /alert{'show'};
                                                $('#template_details').show( "slow", function() {
                                                    // Animation complete.
                                                });
                                            }
                                            else
                                            {
                                                $('#template_details').hide( "slow", function() {
                                                    // Animation complete.
                                                });
                                            }
                                        });
                                    });

                                </script>


	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{ asset('/assets/js/uikit/vendor/codemirror/codemirror.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/uikit/uikit.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/uikit/css/addons/uikit.almost-flat.addons.min.css') }}">

	<!-- Imported scripts on this page -->
	<script src="{{ asset('/assets/js/uikit/vendor/codemirror/codemirror.js') }}"></script>
	<script src="{{ asset('/assets/js/uikit/vendor/marked.js') }}"></script>
	<script src="{{ asset('/assets/js/uikit/js/uikit.min.js') }}"></script>
	<script src="{{ asset('/assets/js/uikit/js/addons/htmleditor.min.js') }}"></script>

</div>
</div>
</div>
</div>
@stop
