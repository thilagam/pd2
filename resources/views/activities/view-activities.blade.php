@extends('../app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">



<div class="panel panel-default" style="background: #E3E3E3 none repeat scroll 0% 0%;">
				
				<div class="panel-body">
					

              <ul class="cbp_tmtimeline">
				<li>
					<time class="cbp_tmtime" datetime="2014-12-06T18:30"><span class="hidden">06/12/2014</span> <span class="large"> 
					{{ $dictionary['act_now'] }}
					</span></time>
					
					<div class="cbp_tmicon timeline-bg-gray">
						<i class="fa-user"></i>
					</div>
					
					<div class="cbp_tmlabel empty">
						<span>{{ $dictionary['act_no_activity'] }}</span>
					</div>
				</li>
				
				@foreach($activity as $act)
				
				<li>
					<time class="cbp_tmtime" datetime="2016-12-06T03:45"><span>{{ $act->act_dt }}</span></time>
					
					<div class="cbp_tmicon timeline-bg-{{ $act->acttype_back_color }}">
						<i class="{{ $act->acttype_icon }}"></i>
					</div>
					
					<div class="cbp_tmlabel">
						<h2><a href="#">{{ $dictionary[$act->actmp_name] }} :- </a> <span>{{ $dictionary[$act->actmp_description] }}</span></h2>
						<p>{{ $act->actmpplus_template }}</p>
					</div>
				</li>
				
			  @endforeach	

@if(isset($act->act_id))
    <div class="more btn-group btn-group-justified" id="morebutton">
   		 <a id="{{ $act->act_id."-".$act->act_product_id }}" class="more btn btn-success bg-lg" href="#" > Load More... </a> 
   	</div>
@endif

				
			</ul>
					
				</div>
			</div>




</div>
</div>
</div>
</div>

<script type="text/javascript">
$(function() {

$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});	
$(".more").click(function() {
   var element = $(this);
   var msg = element.attr("id");   
   //alert(msg);
   $("#morebutton").html('<img src="/assets/images/ajax-loader.gif" />');
   $(".more").remove();
	$.ajax({
	         type: "GET",
  			 url: "/activities/"+msg,
  			 success: function(data){
					 $(".cbp_tmtimeline").append(data);
			 }
		   });
	return false;
});
//---------------- Delete Button----------------


});
</script>

@endsection

