@extends('../app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

@if($permit->crud_keyword_translations_create)
 <a href="{{url('/keyword-translations/create')}}" class="btn btn-primary btn-sm">Create</a>
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
         <th>Keyword</th>
         <th>Language</th>
         <th>Word</th>
         <th>Status</th>
         <th>Actions</th>
         <th></th>
         <th></th>
     </tr>
     </thead>
     <tbody>
     @foreach ($keyword_translations as $keyword_translation)
         <tr>
             <td>{{ $keyword_translation->kwtrans_id }}</td>
             <td>@if(isset($keyword_translation->keyword->kw_name)) {{  $keyword_translation->keyword->kw_name }} @endif</td>
             <td>@if(isset($keyword_translation->language->lang_name)) {{ $keyword_translation->language->lang_name }} @endif</td>
             <td>{{ $keyword_translation->kwtrans_word }}</td>
             <td>@if($keyword_translation->kwtrans_status == 1) 
                     Active 
                 @else 
                     In-Active 
                 @endif
             </td>
             <td>
             @if($permit->crud_keyword_translations_read)
             <a href="{{url('keyword-translations',$keyword_translation->kwtrans_id)}}" class="btn btn-primary btn-sm btn-icon icon-left">Read</a>
             @endif
             </td>
             <td>
             @if($permit->crud_keyword_translations_edit)
             <a href="{{route('keyword-translations.edit',$keyword_translation->kwtrans_id)}}" class="btn btn-secondary btn-sm btn-icon icon-left">Update</a>
             @endif
             </td>
             <td>
            @if($permit->crud_keyword_translations_delete)
             {!! Form::open(['method' => 'DELETE', 'route'=>['keyword-translations.destroy', $keyword_translation->kwtrans_id]]) !!}
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
