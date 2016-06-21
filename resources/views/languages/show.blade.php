@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form >
        <div class="form-group">
            <label for="Language Name">Language Name</label>

<input type="text" class="form-control" id="lang_name" placeholder="{{$language->lang_name}}" readonly>

        </div>
        <div class="form-group">
            <label for="Language Code">Language Code</label>

                <input type="text" class="form-control" id="lang_code" placeholder="{{$language->lang_code}}" readonly>

        </div>
        <div class="form-group">
            <label for="Language Status" >Language Status</label>

				<select id="lang_status" class="form-control" readonly>
					<option value="1" @if ($language->lang_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($language->lang_status == 0) selected @endif >In Active</option>
				</select> 	

        </div>
        <div class="form-group">
                <a href="{{ url('languages')}}" class="btn btn-purple pull-right">Back</a>

        </div>
    </form>

</div>
</div>
</div>
</div>

@stop
