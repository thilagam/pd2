@extends('../app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

<script type="text/javascript">
jQuery(document).ready(function($)
{
	$("#example-221").dataTable({  });
         // Replace checkboxes when they appear
});
</script>
<meta name="_token" content="{{ csrf_token() }}"/>
<table class="table table-bordered table-striped" id="example">
		<thead>
		<tr class="bg-info">
		<th>{{ $dictionary['pr_perm_and_group'] }}</th>
		@foreach ($groups as $group)
    <th><span class="btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $group->group_name  }}">{{ $group->group_code }}</span></th>
    @endforeach

    </tr>
		</thead>
		<tbody>
		@foreach ($permissions as $permission)
      <tr>
			   <td>
            {{ $permission->perm_keyword }}  <span class="pull-right" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $permission->perm_description }}"><i class="fa fa-list-alt"></i></span> 
         </td>
		      @foreach ($groups as $group)
				    {{--*/ $flag_check = 0 /*--}}
				    @foreach ($group_permissions as $gp)
               @if($gp->gp_permission == 1 && $gp->gp_perm_id == $permission->perm_id && $gp->gp_group_id == $group->group_id)
				       {{--*/ $flag_check = 1 /*--}}
				       @endif
				    @endforeach
				  <td>
  					@if($flag_check)
              <button id="{{ $group->group_id }}|{{$permission->perm_id }}|0" class="btn btn-icon btn-red ajaxsubmit"><i class="fa-thumbs-o-down"></i></button>
  					@else
  					  <button id="{{ $group->group_id }}|{{$permission->perm_id }}|1"  class="btn btn-icon btn-success ajaxsubmit"><i class="fa-thumbs-o-up"></i></button>
  					@endif
  				</td>
			    @endforeach
			 </tr>
		        @endforeach
			</tbody>
</table>

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

$("document").ready(function(){

$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
});

    $(".ajaxsubmit").on("click",function(){
        var dataString="perm="+$(this).attr('id');
//        alert(dataString);
	  $.ajax({
               type: "GET",
               url : "/permissions/update",
               data : dataString,
	       datatype: "html",
               success : function(data){
//		     alert(data);

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
	var data_array = $(this).attr('id').split("|");
	if(data_array[2] == 0){
		$(this).removeClass("btn-red").addClass("btn-success");
		$(this).html("<i class='fa-thumbs-o-up'>");
		$(this).attr('id',data_array[0]+"|"+data_array[1]+"|"+1);
	}else{
                $(this).removeClass("btn-success").addClass("btn-red");
		$(this).html("<i class='fa-thumbs-o-down'>");
                $(this).attr('id',data_array[0]+"|"+data_array[1]+"|"+0);
	}
    });

</script>

  <!-- Imported scripts on this page -->
  <script src="{{ asset('/assets/js/toastr/toastr.min.js') }}"></script>

</div>
</div>
</div>
</div>

@endsection
