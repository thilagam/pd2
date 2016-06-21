@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form>
        <div class="form-group">
            <label for="Name">Keyword Name</label>
                <input type="text" class="form-control" id="lang_name" placeholder="{{$keyword->kw_name}}" readonly>
        </div>
        <div class="form-group">
            <label for="Module">Keyword Module</label>
            	<select class="form-control" readonly>
					<option value="">--Select--</option>
				@foreach ($modules_array as $key=>$modarr)
				   <option value="{{ $key }}" @if ($keyword->kw_module_id == $key) selected @endif >{{ $modarr }}</option>		
				@endforeach
	        </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
		<select  class="form-control" readonly>
			<option value="1" @if ($keyword->lang_status == 1) selected @endif >Active</option>
			<option value="0" @if ($keyword->lang_status == 0) selected @endif >In Active</option>
		</select>
        </div>
        <div class="form-group">
                <a href="{{ url('keywords')}}" class="btn btn-purple pull-right">Back</a>
        </div>
    </form>

</div>
</div>
</div>
</div>

@stop
