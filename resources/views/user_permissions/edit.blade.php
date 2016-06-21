@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

	     @include("blocks.error_block")
    {!! Form::model($user_permission,['method' => 'PATCH','route'=>['user-permissions.update',$user_permission->uperm_id]]) !!} 
        <div class="form-group">
            <label for="user">User</label>
                 <select name="uperm_user_id" class="form-control" readonly>
		     <option value="">--Select--</option>
			@foreach ($users as $key=>$usarr)
		            <option value="{{ $key }}" @if ($user_permission->uperm_user_id == $key) selected @endif >{{ $usarr }}</option>
			@endforeach
		</select>
        </div>
        <div class="form-group">
            <label for="enable prem">Enabled Perm</label>
		 <select name="uperm_enabled[]" multiple class="form-control" readonly>
                        @foreach ($permissions as $key=>$perm)
                            <option value="{{ $key }}" @if (strstr($user_permission['uperm_enabled'],$perm)) selected @endif >{{ $perm }}</option>
                        @endforeach
                </select>
        </div>
        <div class="form-group">
            <label for="title">Disbaled Perm</label>
                 <select name="uperm_disabled[]" multiple class="form-control" readonly>
                        @foreach ($permissions as $key=>$perm)
                            <option value="{{ $key }}" @if (strstr($user_permission['uperm_disabled'],$perm)) selected @endif >{{ $perm }}</option>
                        @endforeach
                </select>
        </div>

        <div class="form-group">
            <label for="author">Status</label>
				<select name="uperm_status" class="form-control" readonly>
					<option value="1" @if ($user_permission->uperm_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($user_permission->uperm_status == 0) selected @endif >In Active</option>
				</select>
        </div>

      <a href="{{ url('user-permissions')}}" class="btn btn-purple">Back</a>
      {!! Form::submit('Update', ['class' => 'btn btn-info btn-single  pull-right']) !!}
      {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}


</div>
</div>
</div>
</div>

@stop
