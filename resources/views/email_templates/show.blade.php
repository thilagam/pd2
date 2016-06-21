@extends('../app')
@section('content')

<div class="row">
    
    <div class="col-sm-12">
        <div class="panel panel-default">
            
            <div class="panel-body">

   
    <form >
        <div class="form-group">
            <label for="Language Code">Template Name</label>

                                <select id="lang_status" class="form-control" readonly>
                                   @foreach($templates_all as $key=>$ta)
                                   <option value="0" @if ($etemplate->etempplus_template_id == $key) selected @endif >{{ $ta  }}</option>
                                    @endforeach
                </select>
        </div>
       <div class="form-group">
            <label for="Language Code">Language</label>

                                <select id="lang_status" class="form-control" readonly>
                                   @foreach($languages as $lang)
                                     <option value="0" @if ($etemplate->etempplus_language_code == $lang->lang_code) selected @endif >{{ $lang->lang_name  }}</option>              				  @endforeach
				</select>
        </div>

        <div class="form-group">
            <label for="Language Code">Template</label>
			<textarea readonly name="etemp_template_code" class="form-control" rows="10" data-uk-htmleditor>
				{{ $etemplate->etempplus_template_code  }} 
			</textarea>

	     </div>



        <div class="form-group">
            <label for="Language Status" >Status</label>

				<select id="lang_status" class="form-control" readonly>
					<option value="1" @if ($etemplate->etemp_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($etemplate->etemp_status == 0) selected @endif >In Active</option>
				</select> 	

        </div>
        <div class="form-group">
                <a href="{{ url('email-templates')}}" class="btn btn-purple pull-right">Back</a>

        </div>
    </form>


        <!-- Imported styles on this page -->
        <link rel="stylesheet" href="{{ asset('/assets/js/uikit/vendor/codemirror/codemirror.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/js/uikit/uikit.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/js/uikit/css/addons/uikit.almost-flat.addons.min.css') }}">

        <!-- Imported scripts on this page -->
        <script src="{{ asset('/assets/js/uikit/vendor/codemirror/codemirror.js') }}"></script>
        <script src="{{ asset('/assets/js/uikit/vendor/marked.js') }}"></script>
        <script src="{{ asset('/assets/js/uikit/js/uikit.min.js') }}"></script>
        <script src="{{ asset('/assets/js/uikit/js/addons/htmleditor.min.js') }}"></script>


</div>
</div>
</div>
</div>

@stop
