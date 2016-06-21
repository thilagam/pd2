@extends('../app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

<script type="text/javascript">
jQuery(document).ready(function($)
{
	$("#example-2").dataTable({  });

         // Replace checkboxes when they appear
});
</script>


{!! Form::open(['url' =>'']) !!}
    @include('blocks.error_block')
    <script type="text/javascript">
		jQuery(document).ready(function($)
		{
			$("#clientList").selectBoxIt({
				showFirstOption: false
			}).on('open', function()
			{
				// Adding Custom Scrollbar
				$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
			});
		});
	</script>
    <div class="form-group">
        {!! Form::label($dictionary['pr_users'], $dictionary['pr_users']) !!}
        {!! Form::select('uid',$users_array,$user_specific_id,['class'=>'form-control user-class','id'=>'clientList']) !!}
    </div>
{!! Form::close() !!}


@if(!empty($final_permissions) && !empty($permissions))

<meta name="_token_l" content="{{ csrf_token() }}"/>
<table class="table table-bordered table-striped" id="example-2">
		<thead>
		<tr class="bg-info">
		<th>#</th>
		<th>{{ $dictionary['pr_permission_id'] }}</th>
        <th>{{ $dictionary['pr_permission_name'] }}</th>
		<th>{{ $dictionary['pr_permission_description'] }}</th>
                </tr>
		</thead>
			<tbody>
		         @foreach ($permissions as $permission)
                                  <tr>
				    <td>
					@if((in_array($permission->perm_id,$enabled_permissions) || in_array($permission->perm_id."1",$final_permissions)) && !in_array($permission->perm_id,$disabled_permissions))
					   <input type="checkbox" checked id="{{ $permission->perm_id }}" class="ajaxsubmit" />
					@else
					   <input type="checkbox" id="{{ $permission->perm_id }}" class="ajaxsubmit" />
					@endif
				    </td>
				    <td>{{ $permission->perm_id }}</td>
				    <td>{{ $permission->perm_keyword }}</td>
				    <td>{{ $permission->perm_description }}</td>
				  </tr>
			@endforeach
			</tbody>
</table>
@endif


<link rel="stylesheet" href="{{ asset('/assets/js/datatables/dataTables.bootstrap.css') }}">
<style>
.td_20_width{ witdh:20%; }
</style>
<script src="{{ asset('/assets/js/datatables/js/jquery.dataTables.min.js') }}"></script>
<!-- Imported scripts on this page -->
<script src="{{ asset('/assets/js/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/tabletools/dataTables.tableTools.min.js') }}"></script>
<script>
$( document ).ready(function(){

   $("#result_message").hide();
   $(".user-class").change(function(){
	//$('form#userForm').submit();
        if($(this).val() > 0)
		window.location.href = "/permissions/users/"+$(this).val();
    });

$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
});

    $(".ajaxsubmit").on('click',function(){
	if($(this).is(':checked'))
            var dataString="uid="+$(".user-class").val()+"&permid="+$(this).attr('id')+"&f=1";
	else
	    var dataString="uid="+$(".user-class").val()+"&permid="+$(this).attr('id')+"&f=0";
	alert(dataString);
	  $.ajax({
               type: "GET",
               url : "/permissions/users-update",
               data : dataString,
	             datatype: "html",
               success : function(data){


			 /* Toster Message */

                var opts = {
                  "closeButton": true,
                  "debug": false,
                  "positionClass": "toast-top-right",
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                };

                toastr.success("{{ $dictionary['gl_success_message'] }}", "{{ $dictionary['gl_success_title'] }}", opts);

             /* Close Toster Message */

		     return true;
               },
         });
    });
</script>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="{{ asset('/assets/js/daterangepicker/daterangepicker-bs3.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2-bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/multiselect/css/multi-select.css') }}">

  <!-- Imported scripts on this page -->
  <script src="{{ asset('/assets/js/toastr/toastr.min.js') }}"></script>

<!-- Imported scripts on this page -->
<script src="{{ asset('/assets/js/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>
<script src="{{ asset('/assets/js/tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('/assets/js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('/assets/js/handlebars.min.js') }}"></script>
<script src="{{ asset('/assets/js/multiselect/js/jquery.multi-select.js') }}"></script>

</div>
</div>
</div>
</div>
@endsection
