@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

	 @if(strcmp($user_logged_in->groups->group_code,"CL") == 0)
	     <p class="pull-right label label-red">You have Permission to create only {{ $user_logged_in->user_max_subaccounts  }} Sub Account </p>	
	 @endif

     @if($user_logged_in->groups->group_code == "SA" || $user_logged_in->groups->group_code == "DEV"  || $user_logged_in->user_max_subaccounts >  $user_logged_in_max_account)

          @include('blocks.error_block')
        {!! Form::open(['url' => 'users','id'=>'createUser','class'=>'validate'] ) !!}
        <div class="form-group">
            {!! Form::label($dictionary['us_add_name'], $dictionary['us_add_name']) !!}
            {!! Form::text('name',null,['class'=>'form-control','placeholder'=>$dictionary['us_add_name_placeholder'] ,'data-validate'=>'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label($dictionary['us_add_email_address'], $dictionary['us_add_email_address']) !!}
            {!! Form::text('email',null,['class'=>'form-control','placeholder'=>$dictionary['us_add_email_address_placeholder'],'data-validate'=>'email,required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label($dictionary['us_add_password'], $dictionary['us_add_password']) !!}
            {!! Form::password('password',['class'=>'form-control','placeholder'=>$dictionary['us_add_password_placeholder'],'data-validate'=>'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label($dictionary['us_add_confirm_password'], $dictionary['us_add_confirm_password']) !!}
            {!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>$dictionary['us_add_confirm_password_placeholder'],'data-validate'=>'required']) !!}
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
            {!! Form::select('group_id', $groups, 'Select', ['id'=>'group_id','class' => 'form-control','placeholder'=>$dictionary['us_add_group_placeholder'],'data-validate'=>'required']) !!}
        </div>
        <div class="form-group">
            <a href="{{ url('users')}}" class="btn btn-purple">{{ $dictionary['us_add_back'] }}</a> 
            {!! Form::submit($dictionary['us_add_save'], ['class' => 'btn btn-info btn-single  pull-right']) !!}
    	    {!! Form::reset($dictionary['us_add_reset'], ['class' => 'btn btn-orange btn-single  pull-right']) !!}
            
        </div>
        {!! Form::close() !!}

    @else
   
<a href="#" class="list-group-item active">
<h4 class="list-group-item-heading">Account Limit</h4>
<p class="list-group-item-text">Account Limit is set by Admin while creating Client. Contact Admin for more details!</p>
</a>


    @endif		

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
