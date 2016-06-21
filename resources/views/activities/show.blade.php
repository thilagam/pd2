@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form >
        <div class="form-group">
            <label for="Name">Name</label>

<input type="text" class="form-control" id="lang_name" placeholder="{{$activity_type->acttype_name}}" readonly>

        </div>
        <div class="form-group">
            <label for="Description">Description</label>

                <textarea class="form-control" id="lang_code" placeholder="" readonly>{{$activity_type->acttype_description }}
                </textarea>

        </div>
        <div class="form-group">
            <label for="Status" >Icon</label>
                <i class="{{ $activity_type->acttype_icon }}"></i>   
            <input type="text" class="form-control" id="lang_name" placeholder="{{ $activity_type->acttype_icon }}" readonly>      
        </div>
        <div class="form-group">
            <label for="Status" >Status</label>

				<select id="lang_status" class="form-control" readonly>
					<option value="1" @if ($activity_type->acttype_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($activity_type->acttype_status == 0) selected @endif >In Active</option>
				</select> 	

        </div>

        <div class="form-group">
                <a href="{{ url('activity-types')}}" class="btn btn-purple pull-right">Back</a>

        </div>
    </form>

</div>
</div>
</div>
</div>

@stop
