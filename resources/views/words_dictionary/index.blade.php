@extends('../app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

<script type="text/javascript">
jQuery(document).ready(function($)
{
        $("#example-2").dataTable({
            "oLanguage": {
                            "sSearch": "{{ $dictionary['dtable_search'] }}"+"{!! $selectLang !!}",
                            "sLengthMenu": "{{ $dictionary['dtable_length_menu_show'] }}"+'&nbsp;<select class="form-control input-sm" aria-controls="example-2" name="example-2_length"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>&nbsp;'+"{{ $dictionary['dtable_length_menu_entries'] }}"
                         }

        });
        
         // Replace checkboxes when they appear
});
</script>
<meta name="_token" content="{{ csrf_token() }}"/>
<table class="table table-bordered table-striped" id="example-2">
		<thead>
		<tr class="bg-info">
		<th>{{ $dictionary['wd_words'] }}</th>
		@foreach ($languages as $language)
                <th>{{ $language->lang_name }} ({{ $language->lang_code  }})</th>
                @endforeach
		<th>{{ $dictionary['wd_action'] }}</th>
                </tr>
		</thead>
			<tbody>
		         @foreach ($keywords as $keyword)
                                  <tr>
				  <td>{{ $keyword->kw_name }}</td>
		             @foreach ($languages as $language)
			       @if(isset($words_dictionary[$keyword->kw_id][$language->lang_code]))
             		     <td><input type="text" name="language_{{ $keyword->kw_id  }}[]" id="{{ $language->lang_code  }}"  class="form-control" value="{{ $words_dictionary[$keyword->kw_id][$language->lang_code] }}" /></td>	
                               @else
                             <td><input type="text" name="language_{{ $keyword->kw_id  }}[]" id="{{ $language->lang_code  }}" class="form-control" value="" /></td>
                               @endif
                             @endforeach  
				  <td><button id="{{ $keyword->kw_id  }}" type="button" class="btn btn-success ajaxsubmit"><i class="fa fa-save"></i></button></td>
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

$( ".lang_select" ).change(function() {
  window.location = "/words-dictionary/"+this.value;
});

$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});

});


    $(".ajaxsubmit").on('click',function(){
        var dataString="";
	var currentId = "language_"+($(this).attr('id'))+"[]";
	  $("input[name='"+currentId+"']").each(function(){
                 dataString += $(this).attr('id')+"="+$(this).val()+"&"; 
          });
	  dataString += "id="+$(this).attr('id');
//	  alert("Changes Saved !");
	  $.ajax({
               type: "GET",
               url : "/words-dictionary/create",
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


		     //alert("Changes Saved !");
		     return true;
               },	
         });
    }); 

</script>

  <!-- Imported scripts on this page -->
  <script src="{{ asset('/assets/js/toastr/toastr.min.js') }}"></script>

</div>
</div>
</div>
</div>

@endsection

