@extends('../app')
@section('content')

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">

    <form>
        <div class="form-group">
            <label for="Variable Name">Variable Name</label>
                <input type="text" class="form-control" id="conf_name" placeholder="{{$config->conf_name}}" readonly>
        </div>
        <div class="form-group">
            <label for="Variable Value">Variable Value</label>
                <input type="text" class="form-control" id="conf_vale" placeholder="{{$config->conf_value}}" readonly>
        </div>
        <div class="form-group">
            <label for="status">Variable Status</label>
				<select id="conf_status" class="form-control" readonly>
					<option value="1" @if ($config->conf_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($config->conf_status == 0) selected @endif >In Active</option>
				</select>
        </div>
        <div class="form-group">
              <a href="{{ url('configs')}}" class="btn btn-purple pull-right">Back</a>
        </div>
    </form>
    
</div>
</div>
</div>
@stop
