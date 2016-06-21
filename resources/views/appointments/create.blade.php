@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

								<style type="text/css">
									.myFile {
											  position: relative;
											  overflow: hidden;
											  float: left;
											  clear: left;
											}
											.myFile input[type="file"] {
											  display: block;
											  position: absolute;
											  top: 0;
											  right: 0;
											  opacity: 0;
											  font-size: 100px;
											  filter: alpha(opacity=0);
											  cursor: pointer;
											}
								</style>

<script type="text/javascript">
jQuery(document).ready(function($)
{
                $(".client-ajax-submit").selectBoxIt({  showFirstOption: false }).on('open', function()
                {
                        // Adding Custom Scrollbar
                    $(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
                });
                $(".product_ajax_data").selectBoxIt({ showFirstOption: false }).on('open', function()
                {
                        // Adding Custom Scrollbar
                    $(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
                });
                $(".epincharge_ajax_data").selectBoxIt({ showFirstOption: false }).on('open', function()
                {
                        // Adding Custom Scrollbar
                    $(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
                });
                $(".clientincharge_ajax_data").selectBoxIt({ showFirstOption: false }).on('open', function()
                {
                        // Adding Custom Scrollbar
                    $(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
                });
                $(".item_ajax_data").selectBoxIt({ showFirstOption: false }).on('open', function()
                {
                        // Adding Custom Scrollbar
                    $(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
                });

});
</script>

      @include('blocks.error_block')
      {!! Form::open(['url'  => 'appointments','class'=>'validate', 'files'=>true]) !!}
<div class="row">
<div class="col-sm-6">
    <div class="form-group">
        {!! Form::label($dictionary['apo_add_client'], $dictionary['apo_add_client']) !!}
        {!! Form::select('apo_client_id',$client_array,null,['class'=>'form-control client-ajax-submit','data-validate'=>'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label($dictionary['apo_add_product'], $dictionary['apo_add_product']) !!}
        {!! Form::select('apo_product_id',$product_array,null,['class'=>'form-control product_ajax_data']) !!}
    </div>
    <div class="form-group">
        {!! Form::label($dictionary['apo_add_item'], $dictionary['apo_add_item']) !!}
        {!! Form::select('apo_item_id',$item_list ,null,['class'=>'form-control item_ajax_data']) !!}
    </div>
    <div class="form-group">
        {!! Form::label($dictionary['apo_add_epincharge'], $dictionary['apo_add_epincharge']) !!}
        {!! Form::select('apo_ep_incharge_id',$epincharge_array,null,['class'=>'form-control epincharge_ajax_data']) !!}
    </div>
        <div class="form-group">
        {!! Form::label($dictionary['apo_add_clientincharge'], $dictionary['apo_add_clientincharge']) !!}
        {!! Form::select('apo_client_incharge_id',$epincharge_array,null,['class'=>'form-control clientincharge_ajax_data']) !!}
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group" style="margin-bottom:10%">
        {!! Form::label($dictionary['apo_add_datetime'], $dictionary['apo_add_datetime']) !!}
        <div class="date-and-time">
        <input type="text" class="form-control datepicker" name="apo_date" data-format="D, dd MM yyyy">
        <input type="text" class="form-control timepicker" name="apo_time" data-template="dropdown" data-show-seconds="true" data-default-time="11:25 AM" data-show-meridian="true" data-minute-step="5" data-second-step="5" />
        </div>
    </div>

    <div class="form-group">
        {!! Form::label($dictionary['apo_add_subject'], $dictionary['apo_add_subject']) !!}
        {!! Form::text('apo_subject',null,['class'=>'form-control epincharge_ajax_data','placeholder'=>$dictionary['apo_add_subject_placeholder']]) !!}
    </div>
    <div class="form-group">
        {!! Form::label($dictionary['apo_add_description'], $dictionary['apo_add_description']) !!}
        {!! Form::textarea('apo_description',null,['class'=>'form-control epincharge_ajax_data','rows'=>'4','placeholder'=>$dictionary['apo_add_description_placeholder']]) !!}
    </div>


<div class="form-group">
<!-- <label class="col-sm-2 control-label" for="field-1">Template</label> -->
{!! Form::label($dictionary['apo_add_attachment'],$dictionary['apo_add_attachment']) !!}

<div class="">
<label class="myFile">
<div class="btn btn-primary btn-icon btn-icon-standalone">
<i class="fa-upload"></i>
 <input type="file" name="files[]" class="btn btn-default" id="template" placeholder="{{ $dictionary['placeholder_upload'] }}" multiple />
<!-- {!! Form::file('file[]','',['class'=>'', 'id'=>'template', 'placeholder'=>$dictionary['placeholder_upload'], 'multiple'=>true ]) !!} -->
<span>Upload </span>
</div>
</label>
</div>
</div>

</div>

<div class="col-sm-12" style="margin-top:2%">
    <div class="form-group">
        <a href="{{ url('appointments')}}" class="btn btn-purple">{{ $dictionary['apo_add_back'] }}</a>
        {!! Form::submit($dictionary['apo_add_save'], ['class' => 'btn btn-info btn-single pull-right']) !!}
	{!! Form::reset($dictionary['apo_add_reset'], ['class' => 'btn btn-orange btn-single pull-right']) !!}
    </div>
</div>
</div>
    {!! Form::close() !!}

 <script>
$("document").ready(function(){

$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});


    $(".client-ajax-submit").on('change',function(){
        var dataString="";
	dataString += "uid="+$(this).val();
	  $.ajax({
               type: "GET",
               url : "/appointments/pdt-ajax-call",
               data : dataString,
	             datatype: "html",
               success : function(data){

$(".product_ajax_data").append(data);
$("select.product_ajax_data").data('selectBox-selectBoxIt').refresh();

		     return true;
               },
         });

          $.ajax({
               type: "GET",
               url : "/appointments/clientincharge-ajax-call",
               data : dataString,
               datatype: "html",
               success : function(data){
//alert(dataString);
$(".clientincharge_ajax_data").append(data);
$("select.clientincharge_ajax_data").data('selectBox-selectBoxIt').refresh();

                     return true;
               },
         });

    });

   $(".product_ajax_data").on('change',function(){
        var dataString = "pid="+$(this).val();
	//alert(dataString);
	   $.ajax({
               type: "GET",
               url : "/appointments/epincharge-ajax-call",
               data : dataString,
               datatype: "html",
               success : function(data){

$("select.epincharge_ajax_data").empty();
$(".epincharge_ajax_data").append(data);
$("select.epincharge_ajax_data").data('selectBox-selectBoxIt').refresh();

                     return true;
               },
         });


   });

});
</script>
 <!-- Imported styles on this page -->
<link rel="stylesheet" href="{{ asset('/assets/js/daterangepicker/daterangepicker-bs3.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2-bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/multiselect/css/multi-select.css') }}">
<!-- Imported scripts on this page -->
<script src="{{ asset('/assets/js/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>
<script src="{{ asset('/assets/js/tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('/assets/js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('/assets/js/handlebars.min.js') }}"></script>
<script src="{{ asset('/assets/js/multiselect/js/jquery.multi-select.js') }}"></script>

<!-- Date Timer Picker -->
<script src="{{ asset('assets/js/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/js/timepicker/bootstrap-timepicker.min.js') }}"></script>

</div>
</div>
</div>
</div>

@stop
