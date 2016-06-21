@extends('../app')

@section('content')

<div class="panel panel-default">
				
				<div class="panel-body">
					<div>
						 @include('blocks.error_block')
					</div>
					<script type="text/javascript">
					jQuery(document).ready(function($)
					{
						//$("#example-2").dataTable();
						 var t = $('#clientListTable').DataTable( {
					        "columnDefs": [ {
					            "searchable": false,
					            "orderable": false,
					            "targets": 0
					        } ],
					        "order": [[ 1, 'asc' ]]
					    } );
					 
					    t.on( 'order.dt search.dt', function () {
					        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
					            cell.innerHTML = i+1;
					        } );
					    } ).draw();
						
						// Replace checkboxes when they appear
						
					});
					</script>
					
					<table class="table table-bordered table-striped" id="clientListTable">
						<thead>
							<tr>
								<th class="no-sorting">
									Sl no
								</th>
								<th>Client</th>
								<th>Product</th>
								<th>Create Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						
						<tbody class="middle-align">
							@foreach ($products as $product)	
								
								<tr>
								<td>
									
								</td>
								<td><a href="{{url('client')}}/{{$product->client_id}}" >{{$product->company}}</a></td>
								<td><a href="{{url('product')}}/{{$product->id}}" >{{ $product->name}}</a></td>
								<td>{{ $product->create_date}}</td>
								<td>
									<a href="{{url('product')}}/{{$product->id}}/edit" class="btn btn-secondary btn-sm btn-icon icon-left">
										Edit
									</a>
									
									<a href="{{url('product/delete')}}/{{$product->id}}" class="btn btn-danger btn-sm btn-icon icon-left">
										Delete
									</a>
									
									<a href="{{url('product')}}/{{$product->id}}" class="btn btn-info btn-sm btn-icon icon-left">
										Profile
									</a>
								</td>
								</tr>
							@endforeach
							
						</tbody>
					</table>
					
				</div>
			</div>

	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{ asset('/assets/js/datatables/dataTables.bootstrap.css') }}">

	
	<script src="{{ asset('/assets/js/datatables/js/jquery.dataTables.min.js') }}"></script>
	<!-- Imported scripts on this page -->
	<script src="{{ asset('/assets/js/datatables/dataTables.bootstrap.js') }}"></script>
	<script src="{{ asset('/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js') }}"></script>
	<script src="{{ asset('/assets/js/datatables/tabletools/dataTables.tableTools.min.js') }}"></script>

@endsection