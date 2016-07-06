@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">


    <form >
           {{-- <div class="form-group">
            <label for="Template">Template</label>
                <select id="lang_status" class="form-control" readonly>
                  @foreach($act_templates_all as $temp)
                     <option value="0" @if ($act_templates->actmp_id == $temp->actmp_id) selected @endif >{{ $temp->actmp_name  }}</option>
                  @endforeach
                </select>
        </div> --}}
        <div class="form-group">
            <label for="Symbol">Template</label>
                <input type="text" class="form-control" placeholder="{{$act_templates->actmp_name}}" readonly>
        </div>
       {{-- <div class="form-group">
            <label for="Language">Language</label>

                                <select id="lang_status" class="form-control" readonly>
                                   @foreach($languages as $lang)
                                     <option value="0" @if ($act_templates->actmpplus_language_code == $lang->lang_code) selected @endif >{{ $lang->lang_name  }}</option>                                @endforeach
                </select>
        </div> --}}
        <div class="form-group">
            <label for="Symbol">Language</label>
                <input type="text" class="form-control" placeholder="{{$act_templates->lang_name}}" readonly>
        </div>
        
        {{-- <div class="form-group">
            <label for="Type">Type</label>

                                <select id="lang_status" class="form-control" readonly>
                                   @foreach($act_templates_type as $type)
                                     <option value="0" @if ($act_templates->actmpplus_type == $type->acttype_id) selected @endif >{{ $type->acttype_name  }}</option>                                @endforeach
                </select>
        </div> --}}
        <div class="form-group">
            <label for="Symbol">Type</label>
                <input type="text" class="form-control" placeholder="{{$act_templates->acttype_name}}" readonly>
        </div>

        <div class="form-group">
            <label for="Language Code">Text</label>
                <textarea class="form-control" readonly>{{ $act_templates->actmpplus_template }}</textarea>
        </div>
        {{-- <div class="form-group">
            <label for="Status" >Status</label>

				<select id="lang_status" class="form-control" readonly>
					<option value="1" @if ($act_templates->actmpplus_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($act_templates->actmpplus_status == 0) selected @endif >In Active</option>
				</select>

        </div> --}}
        <div class="form-group">
            <label for="Symbol">Status</label>
                <input type="text" class="form-control" placeholder=" @if($act_templates->actmpplus_status == 1) Active @else Inactive @endif" readonly>
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
