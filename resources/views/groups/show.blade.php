@extends('../app')
@section('content')

<div class="panel panel-default">
    <div class="panel-body">

    <h4>{{ $dictionary['gp_group_show'] }}</h4>
    <form>
        <div class="form-group">
            <label for="name">{{ $dictionary['gp_group_name'] }}</label>
		<input type="text" class="form-control" placeholder="{{$group->group_name}}" readonly>
        </div>
        <div class="form-group">
            <label for="Description">{{ $dictionary['gp_group_description'] }}</label>
                <input type="text" class="form-control" placeholder="{{$group->group_description}}" readonly>
        </div>
        <div class="form-group">
            <label for="Group Code">{{ $dictionary['gp_group_code'] }}</label>
                <input type="text" class="form-control" placeholder="{{$group->group_code}}" readonly>
        </div>
        <div class="form-group">
            <label for="Status">{{ $dictionary['gp_group_status'] }}</label>
				<select class="form-control" readonly>
					<option value="1" @if ($group->group_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($group->group_status == 0) selected @endif >In Active</option>
				</select>
        </div>
        <div class="form-group">
                <a href="{{ url('groups')}}" class="btn btn-purple pull-right">{{ $dictionary['gp_group_back'] }}</a>
        </div>
    </form>

    </div>
</div>

@stop
