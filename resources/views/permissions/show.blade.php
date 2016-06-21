@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form>
        <div class="form-group">
            <label for="keyword">Keyword</label>        
                <input type="text" class="form-control" id="perm_keyword" placeholder="{{$permission->perm_keyword}}" readonly>
        </div>
        <div class="form-group">
            <label for="Description">Description</label>
                <textarea  class="form-control" id="perm_description" placeholder="{{$permission->perm_description}}" readonly></textarea>
        </div>
        <div class="form-group">
            <label for="Status">Status</label>
		  <select id="lang_status" class="form-control" readonly>
			<option value="1" @if ($permission->perm_status == 1) selected @endif >Active</option>
		        <option value="0" @if ($permission->perm_status == 0) selected @endif >In Active</option>
		  </select>
        </div>
        <div class="form-group">
                <a href="{{ url('permissions')}}" class="btn btn-purple pull-right">Back</a>
        </div>
    </form>

</div>
</div>
</div>
</div>    
@stop
