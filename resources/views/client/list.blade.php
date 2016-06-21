@extends('../app')

@section('content')

<div class="panel panel-default">
				
				<div class="panel-body">
					
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
								<th>Products</th>
								<th>Create Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						
						<tbody class="middle-align">
							@foreach ($clients as $client)	
								
								<tr>
								<td>
									
								</td>
								<td><a href="{{url('client')}}/{{$client->id}}" >{{$client->company}}</a></td>
								<td>{{ $client->products}}</td>
								<td>{{ $client->create_date}}</td>
								<td>
									<a href="{{url('client')}}/{{$client->id}}/edit" class="btn btn-secondary btn-sm btn-icon icon-left">
										Edit
									</a>
									
									<a href="{{url('client/delete')}}/{{$client->id}}" class="btn btn-danger btn-sm btn-icon icon-left">
										Delete
									</a>
									
									<a href="{{url('client')}}/{{$client->id}}" class="btn btn-info btn-sm btn-icon icon-left">
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