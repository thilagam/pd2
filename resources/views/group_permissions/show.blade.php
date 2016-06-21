@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form>
        <div class="form-group">
            <label for="permissions keyword">Permission Keyword</label>
                <select id="gp_perm_id" class="form-control" readonly>
		    <option value="">--Select--</option>
			@foreach ($permissions as $key=>$perm)
		              <option value="{{ $key }}" @if ($group_permission->permission->perm_id == $key) selected @endif >{{ $perm }}</option>
			@endforeach
		</select>
        </div>
        <div class="form-group">
            <label for="group name">Group Name</label>
            <select id="lang_status" class="form-control" readonly>
		<option value="">--Select--</option>
		   @foreach ($groups as $key=>$grp)
		   <option value="{{ $key }}" @if ($group_permission->gp_group_id == $key) selected @endif >{{ $grp }}</option>				
		   @endforeach
	    </select>
        </div>
        <div class="form-group">
            <label for="permissions">Permission</label>
                                <select id="permission" class="form-control" readonly>
                                        <option value="1" @if ($group_permission->gp_permission == 1) selected @endif >Allow</option>
                                    <option value="0" @if ($group_permission->gp_permission == 0) selected @endif >Deny</option>
                                </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
				<select id="lang_status" class="form-control" readonly>
					<option value="1" @if ($group_permission->gp_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($group_permission->gp_status == 0) selected @endif >In Active</option>
				</select>
        </div>
        <div class="form-group">
                <a href="{{ url('group-permissions')}}" class="btn btn-purple">Back</a>
            </div>
        </div>
    </form>

</div>
</div>
</div>
</div>

@stop
