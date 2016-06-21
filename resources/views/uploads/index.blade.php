@extends('../app')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body">

@if($permit->crud_languages_create)
<a href="{{ url('/languages/create') }}" class="btn btn-primary btn-sm" >Create</a>
@endif

<script type="text/javascript">
jQuery(document).ready(function($)
{
	$("#example-2").dataTable({
         });

         // Replace checkboxes when they appear
});
</script>


<table class="table table-bordered table-striped" id="example-2">
		<thead>
		<tr class="bg-info">
		<th>#</th>
		<th>Type</th>
		<th>Original Name</th>
		<th>Name</th>
		<th>Status</th>
		<th></th>
    </tr>
		</thead>
			<tbody>
			          @foreach ($uploads as $up)
                                       <tr>
					<td> {{ $up->upload_id }} </td>
					<td> {{ $up->upload_type }} </td>
					<td> {{ $up->upload_original_name }} </td>
					<td> {{ $up->upload_name }} </td>
					<td>	@if($up->upload_status == 1)  Active @else In-Active @endif </td>
					<td> <a href="{{url('upload-logs',$up->upload_id)}}" class="btn btn-primary btn-sm btn-icon icon-left"><i class="fa fa-eye"></i></a>
						   <a href="{{ url('/download/'.Crypt::encrypt($up->upload_url).'/s') }}" class="btn btn-primary btn-sm btn-icon icon-left"><i class="fa-download"></i></a>
					</td>
					</tr>
				   @endforeach

			</tbody>
</table>

<link rel="stylesheet" href="{{ asset('/assets/js/datatables/dataTables.bootstrap.css') }}">

<script src="{{ asset('/assets/js/datatables/js/jquery.dataTables.min.js') }}"></script>
<!-- Imported scripts on this page -->
<script src="{{ asset('/assets/js/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/tabletools/dataTables.tableTools.min.js') }}"></script>

</div>
</div>
</div>
</div>

@endsection
