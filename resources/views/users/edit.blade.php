@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">


     @include('blocks.error_block')  
    {!! Form::model($user,['method' => 'PATCH','route'=>['users.update',$user->id]]) !!}
            <div class="form-group">
            {!! Form::label($dictionary['us_add_name'], $dictionary['us_add_name']) !!}
            {!! Form::text('name',$user->name,['class'=>'form-control','placeholder'=>$dictionary['us_add_name_placeholder']]) !!}
        </div>
        <div class="form-group">
            {!! Form::label($dictionary['us_add_email_address'], $dictionary['us_add_email_address']) !!}
            {!! Form::text('email',$user->email,['class'=>'form-control','placeholder'=>$dictionary['us_add_email_address_placeholder']]) !!}
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {
                $("#group_id").selectBoxIt({
                    showFirstOption: false
                }).on('open', function()
                {
                    // Adding Custom Scrollbar
                    $(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
                });
            });
        </script>
        <div class="form-group">
            {!! Form::label($dictionary['us_add_group'], $dictionary['us_add_group']) !!}
            {!! Form::select('group_id', $groups, $user->group_id, ['id'=>'group_id','class' => 'form-control','placeholder'=>$dictionary['us_add_group_placeholder']]) !!}
        </div>
            <div class="form-group">
				<a href="{{ url('users')}}" class="btn btn-purple">{{ $dictionary['us_add_back'] }}</a> 
               {!! Form::submit($dictionary['us_add_update'], ['class' => 'btn btn-info btn-single  pull-right']) !!} 
	           {!! Form::reset($dictionary['us_add_reset'], ['class' => 'btn btn-orange btn-single  pull-right']) !!}         
    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>


<!-- Imported styles on this page -->
    
    <link rel="stylesheet" href="{{ asset('/assets/js/select2/select2..css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/js/select2/select2-bootstrap..css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/js/multiselect/css/multi-select..css') }}">

    

<!-- Imported scripts on this page -->
    <script src="{{ asset('/assets/js/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/assets/js/inputmask/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('/assets/js/formwizard/jquery.bootstrap.wizard.min.js') }}"></script>
   
    <script src="{{ asset('/assets/js/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>
    



    <!-- JavaScripts initializations and stuff -->
    <script src="{{ asset('/assets/js/xenon-custom.js') }}"></script>

@stop
