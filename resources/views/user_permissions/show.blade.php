@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form>
        <div class="form-group">
            <label for="user">User</label>
            <select id="user" class="form-control" readonly>
		     <option value="">--Select--</option>
			@foreach ($users as $key=>$usarr)
		            <option value="{{ $key }}" @if ($user_permission->uperm_user_id == $key) selected @endif >{{ $usarr }}</option>
			@endforeach
	    </select>
        </div>
        <div class="form-group">
            <label for="enable perm">Enabled Perm</label>
		 <select multiple class="form-control" readonly>
                        @foreach ($permissions as $key=>$perm)
                            <option value="{{ $key }}" @if (strstr($user_permission['uperm_enabled'],$perm)) selected @endif >{{ $perm }}</option>
                        @endforeach
                </select>
        </div>
        <div class="form-group">
            <label for="disable perm">Disbaled Perm</label>
                 <select  multiple class="form-control" readonly>
                        @foreach ($permissions as $key=>$perm)
                            <option value="{{ $key }}" @if (strstr($user_permission['uperm_disabled'],$perm)) selected @endif >{{ $perm }}</option>
                        @endforeach
                </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
				<select class="form-control" readonly>
					<option value="1" @if ($user_permission->uperm_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($user_permission->uperm_status == 0) selected @endif >In Active</option>
				</select>
        </div>
        <div class="form-group">
            <a href="{{ url('user-permissions')}}" class="btn btn-purple pull-right">Back</a>
        </div>
    </form>

</div>
</div>
</div>
</div>

@stop
