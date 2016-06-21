@extends('../app')

@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-body">

@if($permit->crud_email_templates_create)
<a href="{{ route('email-templates.create') }}" class="btn btn-primary btn-sm" >Create</a>
@endif

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


<table class="table table-bordered table-striped" id="example-2">
		<thead>
		<tr class="bg-info">
		<th>#</th>
		<th>Name</th>
		<th>Description</th>
		<th>Language</th>
		<th>Status</th>
		<th>Actions</th>
		<th></th>
		<th></th>
                </tr>
		</thead>
			<tbody>
			          @foreach ($etemplates as  $et)
                                       <tr>
					<td> {{ $et->etemp_id }} </td>
					<td> {{ $et->etemp_name }} </td>
					<td> {{ $et->etemp_description }} </td>
					<td> {{ $et->lang_name }} </td> 
					<td>
						@if($et->etempplus_status == 1)  Active @else In-Active @endif
                                        </td>
					<td>
					@if($permit->crud_email_templates_read)
					     <a href="{{url('email-templates',$et->etempplus_id)}}" class="btn btn-primary btn-sm btn-icon icon-left">Read</a>
					@endif
					</td><td>
					@if($permit->crud_email_templates_edit)					
					<a href="{{ route('email-templates.edit',$et->etempplus_id)}}" class="btn btn-secondary btn-sm btn-icon icon-left">Update</a>
					@endif
					</td><td>
		@if($permit->crud_email_templates_delete)	
             {!! Form::open(['method' => 'DELETE', 'route'=>['email-templates.destroy', $et->etempplus_id]]) !!}
             {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm btn-icon icon-left','onclick' => 'return confirm("'.$dictionary['delete_confirm_alert'].'");']) !!}
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

