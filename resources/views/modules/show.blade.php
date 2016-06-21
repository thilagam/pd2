@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form>
        <div class="form-group">
            <label for="Module Name">Name</label>
                <input type="text" class="form-control" id="lang_name" placeholder="{{$module->mod_name}}" readonly>
        </div>
        <div class="form-group">
            <label for="Module URL">Module URL</label>
	        <input type="text" class="form-control" id="mod_url" placeholder="{{$module->mod_url}}" readonly>
         </div>
        <div class="form-group">
            <label for="Status" >Status</label>
            <select id="mod_status" class="form-control" readonly>
			<option value="1" @if ($module->mod_status == 1) selected @endif >Active</option>
	                <option value="0" @if ($module->mod_status == 0) selected @endif >In Active</option>
	    </select> 	
        </div>
        <div class="form-group">
            <a href="{{ url('modules')}}" class="btn btn-purple pull-right">Back</a>
        </div>
    </form>

</div>
</div>
</div>  
</div>  
@stop
