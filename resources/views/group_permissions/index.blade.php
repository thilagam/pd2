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
@if($permit->crud_group_permissions_create)
<a href="{{url('/group-permissions/create')}}" class="btn btn-primary">Create</a>
@endif
<table class="table table-striped table-bordered table-hover" id="example-2">
     <thead>
     <tr class="bg-info">
         <th>Id</th>
         <th>Permission Keywords</th>
         <th>Group Name</th>
         <th>Permission Status</th>
	 <th>Status</th>
         <th>Actions</th>
	 <th></th>
	 <th></th>
     </tr>
     </thead>
     <tbody>
     @foreach ($group_permissions as $gp)
         <tr>
             <td>{{ $gp->gp_id }}</td>
             <td>{{ $gp->permission->perm_keyword }}</td>
             <td>{{ $gp->group->group_name}}</td>
 	     <td>@if($gp->gp_permission == 1)
                    Allow
                 @else
                    Deny
                 @endif 
             </td>
             <td>@if($gp->gp_status == 1) 
                     Active 
                 @else 
                     In-Active 
                 @endif
             </td>
             <td>
             @if($permit->crud_group_permissions_read)
             <a href="{{url('group-permissions',$gp->gp_id)}}" class="btn btn-primary btn-sm btn-icon icon-left">Read</a>
             @endif
             </td>
             <td>
             @if($permit->crud_group_permissions_edit)
             <a href="{{route('group-permissions.edit',$gp->gp_id)}}" class="btn btn-secondary btn-sm btn-icon icon-left">Update</a>
             @endif
             </td>
             <td>
            @if($permit->crud_group_permissions_delete) 
             {!! Form::open(['method' => 'DELETE', 'route'=>['group-permissions.destroy', $gp->gp_id]]) !!}
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
