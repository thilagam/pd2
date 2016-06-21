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
         });

         // Replace checkboxes when they appear
});
</script>


<table class="table table-bordered table-striped" id="example-2">
		<thead>
		<tr class="bg-info">
		<th>#</th>
		<th>Date</th>
		<th>Type</th>
		<th>Name</th>
		<th></th>
    </tr>
		</thead>
			<tbody>
			  @foreach ($downloads as $dwl)
         <tr>
					<td> {{ $dwl->download_id }} </td>
					<td> {{ $dwl->download_date }} </td>
					<td> {{ $dwl->download_type }} </td>
					<td> {{ $dwl->download_name }} </td>
					<td> <a href="{{url('download-logs',$dwl->download_id)}}" class="btn btn-primary btn-sm btn-icon icon-left"><i class="fa fa-eye"></i></a>
						   <a href="{{ url('/download/'.Crypt::encrypt($dwl->download_url).'/s') }}" class="btn btn-primary btn-sm btn-icon icon-left"><i class="fa-download"></i></a>
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
