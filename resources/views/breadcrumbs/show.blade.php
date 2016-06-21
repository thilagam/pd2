@extends('../app')
@section('content')
    
<div class="col-sm-12">
<div class="panel panel-default">
    <div class="panel-body">

    <form >
        <div class="form-group">
            <label for="Module">Module</label>
		<select class="form-control" readonly>
		@foreach($modules as $mod)
		   @if($mod->mod_id == $breadcrumb->breadcrumb_module_id)   
			<option selected value="{{ $mod->mod_id  }}">{{ $mod->mod_name  }}</option>
		   @else
                        <option selected value="{{ $mod->mod_id  }}">{{ $mod->mod_name  }}</option>
		   @endif	
		@endforeach
		</select>

        </div>
        <div class="form-group">
            <label for="Language Code">Name</label>

                <input type="text" class="form-control" placeholder="{{ $breadcrumb->breadcrumb_name }}" readonly>

        </div>
        <div class="form-group">
            <label for="Language Code">Description</label>

                <input type="text" class="form-control" placeholder="{{ $breadcrumb->breadcrumb_description }}" readonly>

        </div>
        <div class="form-group">
            <label for="Language Code">Page Title</label>

                <input type="text" class="form-control" placeholder="{{ $breadcrumb->breadcrumb_page_title }}" readonly>

        </div>

       <div class="form-group">
            <label for="Language Code">Url</label>

                <input type="text" class="form-control" placeholder="{{ $breadcrumb->breadcrumb_url }}" readonly>

        </div> 
	<div class="form-group">
            <label for="Language Status" >Status</label>

				<select id="lang_status" class="form-control" readonly>
					<option value="1" @if($breadcrumb->breadcrumb_status == 1) selected @endif >Active</option>
				    <option value="0" @if($breadcrumb->breadcrumb_status == 0) selected @endif >In Active</option>
				</select> 	

        </div>
        <div class="form-group">
                <a href="{{ url('breadcrumbs')}}" class="btn btn-purple pull-right">Back</a>

        </div>
    </form>

</div>
</div>
</div>

@stop
