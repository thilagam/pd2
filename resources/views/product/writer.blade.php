@extends('../app')
@section('content')

<div class="row">

@if($permit->module_product_writer)
    <div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{ $dictionary['write_files'] }}</h3>
			</div>
			<div class="panel-body">

<script type="text/javascript">
jQuery(document).ready(function($)
{
        $("#example-2").dataTable({
            "oLanguage": {
                            "sSearch": "{{ $dictionary['dtable_search'] }}",
                            "sLengthMenu": "{{ $dictionary['dtable_length_menu_show'] }}"+'&nbsp;<select class="form-control input-sm" aria-controls="example-2" name="example-2_length"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>&nbsp;'+"{{ $dictionary['dtable_length_menu_entries'] }}"
                         }

        });
        
         // Replace checkboxes when they appear
});
</script>
				<table class="table table-striped table-bordered table-hover" id="example-2">
					<thead>
						<tr class="bg-info">
							<th>{{ $dictionary['fprwd_date'] }}</th>
							<th>{{ $dictionary['fprwd_name'] }}</th>
							<th>{{ $dictionary['fprwd_description'] }}</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					
					<tbody>
						@foreach($writerFileList as $wfl)
						  <tr>
						    <td>{{ $wfl->dt }}</td>
							<td>{{ $wfl->download_name }}</td>
						  	<td>{{ $wfl->download_description }}</td>
						  	<td>
						  		<a href="{{ url('/download/'.$wfl->download_id) }}" class="btn btn-info btn-sm btn-icon icon-left">
									<i class="fa-download"></i>
								</a>
						  	</td>
						  </tr>
					    @endforeach	
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endif

</div>


<link rel="stylesheet" href="{{ asset('/assets/js/datatables/dataTables.bootstrap.css') }}">

<script src="{{ asset('/assets/js/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>

<script src="{{ asset('/assets/js/datatables/js/jquery.dataTables.min.js') }}"></script>
<!-- Imported scripts on this page -->
<script src="{{ asset('/assets/js/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/tabletools/dataTables.tableTools.min.js') }}"></script>

<script>
function assignUrl(url_value){
	document.productrefverify.action = "/product/refuploadverify/"+url_value;
}
</script>


@endsection
