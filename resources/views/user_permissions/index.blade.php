@extends('../app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

@if($permit->crud_group_permissions_create)
 <a href="{{url('/user-permissions/create')}}" class="btn btn-primary">Create</a>
@endif

<script type="text/javascript">
jQuery(document).ready(function($)
{
        $("#example-2").dataTable({
         });
        
         // Replace checkboxes when they appear
});
</script>
 <table class="table table-striped table-bordered table-hover" id="example-2">
     <thead>
     <tr class="bg-info">
         <th>Id</th>
         <th>User : Email [ID]</th>
         <th>Enabled Perm</th>
	 <th>Disbaled Perm</th>
         <th>Status</th>
         <th>Actions</th>
	 <th></th>
	 <th></th>
     </tr>
     </thead>
     <tbody>
     @foreach ($user_permission as $up)
         <tr>
             <td>{{ $up->uperm_id }}</td>
             <td>@if(isset($up->user->name)) {{ $up->user->name }} @endif : @if(isset($up->user->email)) {{ $up->user->email }} @endif [{{$up->uperm_user_id}}]</td>
             <td>{{ $up->uperm_enabled }}</td>
             <td>{{ $up->uperm_disabled }}</td>		
             <td>@if($up->uperm_status == 1) 
                     Active 
                 @else 
                     In-Active 
                 @endif
             </td>
             <td>
@if($permit->crud_group_permissions_read)
             <a href="{{url('user-permissions',$up->uperm_id)}}" class="btn btn-primary btn-sm btn-icon icon-left">Read</a>
@endif
             </td>
             <td>
@if($permit->crud_group_permissions_edit)
             <a href="{{route('user-permissions.edit',$up->uperm_id)}}" class="btn btn-secondary btn-sm btn-icon icon-left">Update</a>
@endif
             </td>
             <td>
@if($permit->crud_group_permissions_delete)
             {!! Form::open(['method' => 'DELETE', 'route'=>['user-permissions.destroy', $up->uperm_id]]) !!}
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
