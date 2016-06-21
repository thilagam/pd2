@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form>
        <div class="form-group">
            <label for="Name">Name</label>
                <input type="text" class="form-control" placeholder="{{$country->country_name}}" readonly>
        </div>
        <div class="form-group">
            <label for="Code">Country Code</label>
                <input type="text" class="form-control" placeholder="{{$country->country_code}}" readonly>
        </div>
        <div class="form-group">
            <label for="ISO">ISO</label>
                <input type="text" class="form-control" placeholder="{{$country->country_iso}}" readonly>
        </div>
        <div class="form-group">
            <label for="Currency">Currency</label>
                <input type="text" class="form-control" placeholder="{{$country->country_currency}}" readonly>
        </div>
       <div class="form-group">
            <label for="Symbol">Currency Symbol</label>
                <input type="text" class="form-control" placeholder="{{$country->country_currency_symbol}}" readonly>
        </div>
        <div class="form-group">
            <label for="Language Code">Language Code</label>
            	<select id="lang_status" class="form-control" readonly>
			<option value="">Select</option>
			@foreach ($languages_array as $key=>$langarr)
			    <option value="{{ $key }}" @if ($country->country_language_code == $key) selected @endif >{{ $langarr }}</option>
			@endforeach
		</select>
        </div>
        <div class="form-group">
            <label for="Status">Status</label>
				<select id="lang_status" class="form-control" readonly>
					<option value="1" @if ($country->country_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($country->country_status == 0) selected @endif >In Active</option>
				</select> 	
        </div>
        <div class="form-group">
                <a href="{{ url('countries')}}" class="btn btn-purple pull-right">Back</a>
        </div>
    </form>

</div>
</div>
</div>
</div>
    
@stop
