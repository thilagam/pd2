@extends('../app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

@if($permit->crud_keywords_create)
 <a href="{{url('/keywords/create')}}" class="btn btn-primary">Create</a>
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
         <th>Module</th>
         <th>Status</th>
         <th>Actions</th>
	 <th></th>
	 <th></th>
     </tr>
     </thead>
     <tbody>
     @foreach ($keywords as $keyword)
         <tr>
             <td>{{ $keyword->kw_id }}</td>
             <td>{{ $keyword->kw_name }}</td>
             <td>{{ $keyword->module->mod_name }}</td>
             <td>@if($keyword->kw_status == 1) 
                     Active 
                 @else 
                     In-Active 
                 @endif
             </td>
             <td>
             @if($permit->crud_keywords_read)
             <a href="{{url('keywords',$keyword->kw_id)}}" class="btn btn-primary btn-sm btn-icon icon-left">Read</a>
             @endif
             </td>
             <td>
             @if($permit->crud_keywords_edit)
             <a href="{{route('keywords.edit',$keyword->kw_id)}}" class="btn btn-warning btn-sm btn-icon icon-left">Update</a>
            @endif
             </td>
             <td>
            @if($permit->crud_keywords_delete)
             {!! Form::open(['method' => 'DELETE', 'route'=>['keywords.destroy', $keyword->kw_id]]) !!}
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
