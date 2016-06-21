@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form>
        <div class="form-group">
            <label for="keyword">Keyword</label>
		<select id="lang_status" class="form-control" readonly>
		<option value="">--Select--</option>
		@foreach ($keywords_array as $key=>$kwarr)
		  <option value="{{ $key }}" @if ($keyword_translation->kwtrans_keyword_id == $key) selected @endif >{{ $kwarr }}</option>
		@endforeach
		</select>
        </div>
        <div class="form-group">
            <label for="Language">Language</label>
		<select id="lang_status" class="form-control" readonly>
         		<option value="">--Select--</option>
			@foreach ($languages_array as $key=>$langarr)
			   <option value="{{ $key }}" @if ($keyword_translation->kwtrans_language_code == $key) selected @endif >{{ $langarr }}</option>
			@endforeach
		</select> 
        </div>
        <div class="form-group">
            <label for="Word">Word</label>
		<input type="text" value="{{ $keyword_translation->kwtrans_word }}" class="form-control" readonly/>
	</div>	        
        <div class="form-group">
            <label for="Status">Status</label>
            	<select class="form-control" readonly>
			<option value="1" @if ($keyword_translation->kwtrans_status == 1) selected @endif >Active</option>
	                <option value="0" @if ($keyword_translation->kwtrans_status == 0) selected @endif >In Active</option>
		</select> 	
        </div>
        <div class="form-group">
            <a href="{{ url('keyword-translations')}}" class="btn btn-purple pull-right">Back</a>
        </div>
    </form>

</div>
</div>
</div>
</div>
@stop
