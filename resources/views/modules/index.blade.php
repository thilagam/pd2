@extends('../app')

@section('content')

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">

@if($permit->crud_modules_create)
 <a href="{{url('/modules/create')}}" class="btn btn-primary">Create</a>
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
         <th>Name</th>
         <th>Url</th>
         <th>Status</th>
         <th>Actions</th>
	 <th></th>
	 <th></th>	
     </tr>
     </thead>
     <tbody>
     @foreach ($modules as $module)
         <tr>
             <td>{{ $module->mod_id }}</td>
             <td>{{ $module->mod_name }}</td>
             <td>{{ $module->mod_url }}</td>
             <td>@if($module->mod_status == 1) 
                     Active 
                 @else 
                     In-Active 
                 @endif
             </td>
             <td>
             @if($permit->crud_modules_read)
             <a href="{{url('modules',$module->mod_id)}}" class="btn btn-primary btn-sm btn-icon icon-left">Read</a>
             @endif
             </td>
             <td>
             @if($permit->crud_modules_edit)
             <a href="{{route('modules.edit',$module->mod_id)}}" class="btn btn-warning btn-sm btn-icon icon-left ">Update</a>
             @endif
             </td>
             <td>
              @if($permit->crud_modules_delete)
             {!! Form::open(['method' => 'DELETE', 'route'=>['modules.destroy', $module->mod_id]]) !!}
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

@endsection
