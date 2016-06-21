@extends('../app')

@section('content')

<div class="col-sm-12">
	<div class="panel panel-default">
		<div class="panel-body">

@if($permit->crud_breadcrumbs_create)
<a href="{{ url('/breadcrumbs/create') }}" class="btn btn-primary btn-sm" >Create</a>
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
		<th>Module</th>
		<th>Name</th>
		<th>Description</th>
		<th>Page Title</th>
        <th>URL</th>
		<th>Status</th>
		<th></th>
		<th></th>
		<th></th>
                </tr>
		</thead>
			<tbody>
			          @foreach ($breadcrumbs as $bd)
                                       <tr>
					<td>{{ $bd->breadcrumb_id }}</td>
					<td> {{ $bd->modules->mod_name }} </td>
					<td> {{ $bd->breadcrumb_name }} </td>
					<td> {{ $bd->breadcrumb_description }} </td>
                                        <td> {{ $bd->breadcrumb_page_title }} </td>
                                        <td> {{ $bd->breadcrumb_url }} </td>
					<td>
						@if($bd->breadcrumb_status == 1)  Active @else In-Active @endif
                                        </td>
					<td>
					@if($permit->crud_breadcrumbs_read)
					     <a href="{{url('breadcrumbs',$bd->breadcrumb_id)}}" class="btn btn-primary btn-sm btn-icon icon-left">Read</a>
					@endif     	
					</td><td>
					@if($permit->crud_breadcrumbs_edit)
					<a href="{{route('breadcrumbs.edit',$bd->breadcrumb_id)}}" class="btn btn-secondary btn-sm btn-icon icon-left">Update</a>
					@endif
					</td><td>
			 @if($permit->crud_breadcrumbs_delete)		
             {!! Form::open(['method' => 'DELETE', 'route'=>['breadcrumbs.destroy', $bd->lang_id]]) !!}
             {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm btn-icon icon-left', 'onclick' => 'return confirm("'.$dictionary['delete_confirm_alert'].'");']) !!}
             @endif

             {!! Form::close() !!}
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

@endsection

