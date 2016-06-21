@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form >
        <div class="form-group">
            <label for="">Description</label>

<textarea class="form-control" rows="5" placeholder="{{$generalSpecs->specgen_description}}" readonly></textarea>

        </div>
        <div class="form-group">
            <label for="">Url</label>

                <input type="text" class="form-control" placeholder="{{$generalSpecs->specgen_url}}" readonly>

        </div>
        
        <div class="form-group">
            <label for="Language">Language</label>
        <select id="lang_status" class="form-control" readonly>
                <option value="">--Select--</option>
            @foreach ($languages_array as $key=>$langarr)
               <option value="{{ $key }}" @if ($generalSpecs->specgen_language_code == $key) selected @endif >{{ $langarr }}</option>
            @endforeach
        </select> 
        </div>

        <div class="form-group">
            <label for="" >Status</label>

				<select class="form-control" readonly>
					<option value="1" @if ($generalSpecs->specgen_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($generalSpecs->specgen_status == 0) selected @endif >In Active</option>
				</select> 	

        </div>
        <div class="form-group">
                <a href="{{ url('general-specifications')}}" class="btn btn-purple pull-right">Back</a>

        </div>
    </form>

</div>
</div>
</div>
</div>

@stop
