@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

      @include('blocks.error_block')
     {!! Form::open(['url' => 'activity-templates']) !!}
        <div class="form-group">
        {!! Form::label('Template', 'Template') !!}
        {!! Form::select('actmp_id',array(''=>'Select')+$act_templates,null,['class'=>'form-control template-class']) !!}
        <p class="help-block">Keep Above field Blank to Add New Template </p>
    </div>
    <div id="template_details">
    <div class="form-group">
        {!! Form::label('Name', 'Name:') !!}
        {!! Form::text('actmp_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Description', 'Description:') !!}
        {!! Form::text('actmp_description',null,['class'=>'form-control']) !!}
    </div>
    </div>
    <div class="form-group">
        {!! Form::label('Language', 'Language') !!}
        {!! Form::select('actmpplus_language_code',array(''=>'Select')+$languages,null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Type', 'Type') !!}
        {!! Form::select('actmpplus_type',array(''=>'Select')+$act_templates_type,null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Text', 'Text') !!}
        <textarea name="actmpplus_template" class="form-control" rows="4"></textarea>
    </div>
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single']) !!}
	    {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single']) !!}
        <a href="{{ url('activity-types')}}" class="btn btn-purple pull-right">Back</a> 
    </div>
    {!! Form::close() !!}

                                <script type="text/javascript">
                                    jQuery(document).ready(function($)
                                    {
                                        $(".template-class").change(function () {
                                            var bool=$(this).val();
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


</div>
</div>
</div>
</div>


@stop


