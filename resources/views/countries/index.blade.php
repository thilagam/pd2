@extends('../app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

@if($permit->crud_countries_create)
<a href="{{url('/countries/create')}}" class="btn btn-primary btn-sm">Create</a>
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
         <th>Code</th>
         <th>ISO</th>
         <th>Currency</th>
         <th>Symbols</th>
         <th>Language</th>
         <th>Status</th>
         <th>Actions</th>
	 <th></th>
	 <th></th>
     </tr>
     </thead>
     <tbody>
     @foreach ($countries as $country)
         <tr>
             <td>{{ $country->country_id }}</td>
             <td>{{ $country->country_name }}</td>
             <td>{{ $country->country_code }}</td>
             <td>{{ $country->country_iso }}</td>
             <td>{{ $country->country_currency }}</td>
             <td>{{ $country->country_currency_symbol }}</td>
             <td>{{ $country->language->lang_name }}</td>
             <td>@if($country->country_status == 1) 
                     Active 
                 @else 
                     In-Active 
                 @endif
             </td>
             <td>
             @if($permit->crud_countries_read)
             <a href="{{url('countries',$country->country_id)}}" class="btn btn-primary btn-sm btn-icon icon-left">Read</a>
             @endif
             </td>
             
             <td>
             @if($permit->crud_countries_edit)
             <a href="{{route('countries.edit',$country->country_id)}}" class="btn btn-secondary btn-sm btn-icon icon-left">Update</a>
             @endif
             </td>
             <td>
            @if($permit->crud_countries_delete)
             {!! Form::open(['method' => 'DELETE', 'route'=>['countries.destroy', $country->country_id]]) !!}
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
