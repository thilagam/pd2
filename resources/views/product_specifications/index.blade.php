@extends('../app')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body">

@if($permit->crud_general_specifications_create)
<a href="{{ url('/product-specifications/create') }}" class="btn btn-primary btn-sm" >Create</a>
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
		<th>Product</th>
		<th>Item</th>
		<th>Url</th>
		<th>Language</th>
		<th>Usage</th>
		<th>Status</th>
		<th>Actions</th>
		<th></th>
		<th></th>
        </tr>
		</thead>
			<tbody>
			          @foreach ($productSpecs as $ps)
                                       <tr>
					<td> {{ $ps->specprod_id }} </td>
					<td> {{ $ps->productdtl->prod_name }} </td>
					<td> {{ $dictionary[$ps->specprod_item_id] }} </td>
					<td> {{ $ps->specprod_url }} </td>
					<td> {{ $ps->language->lang_name }} </td>
					<td> {{ str_limit($ps->specprod_usage,30) }} </td>
					<td>
						@if($ps->specprod_status == 1)  Active @else In-Active @endif
                    </td>
					<td>
					@if($permit->crud_general_specifications_read)
					<a href="{{url('product-specifications',$ps->specprod_id)}}" class="btn btn-primary btn-sm btn-icon icon-left">Read</a>
					@endif
					</td>
					<td>
					@if($permit->crud_general_specifications_update)
					<a href="{{route('product-specifications.edit',$ps->specprod_id)}}" class="btn btn-secondary btn-sm btn-icon icon-left">Update</a>
					@endif
					</td><td>
		@if($permit->crud_general_specifications_delete)
             {!! Form::open(['method' => 'DELETE', 'route'=>['product-specifications.destroy', $ps->specprod_id."-".$ps->specprod_spec_id]]) !!}
             {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm btn-icon icon-left', 'onclick' => 'return confirm("'.$dictionary['delete_confirm_alert'].'");']) !!}
             {!! Form::close() !!}
        @endif
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

