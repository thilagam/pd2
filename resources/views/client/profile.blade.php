@extends('../app')

@section('content')

<section class="profile-env">
				
	<div class="row">
	
		<div class="col-sm-3">
			
			<!-- User Info Sidebar -->
			<div class="user-info-sidebar">
				
				<a href="#" class="user-img">
					<!-- <img src="{{ asset('/assets/images/user-4.png')}}" alt="user-img" class="img-cirlce img-responsive img-thumbnail" /> -->
					<img src="@if($client->user_plus['up_profile_image']!='') {{ asset('uploads/'.$client->user_plus['up_profile_image'])}}@else {{ asset('/assets/images/user-4.png')}} @endif" alt="user-img" class="img-cirlce img-responsive img-thumbnail"  width="100px" height="100px;" />
				</a>
				
				<a href="#" class="user-name">
					{{ ucfirst($client->user_plus['up_first_name'])}} {{ucfirst($client->user_plus['up_last_name'])}}
					<span class="user-status is-online"></span>
				</a>
				
				<span class="user-title">
					{{ ucfirst($client->user_plus['up_designation']) }}  at <strong>{{ ucfirst($client->user_plus['up_company_name']) }}</strong>
				</span>
				
				<hr />
				
				<ul class="list-unstyled user-info-list">
					<li>
						<i class="fa-home"></i>
						
						{{ ucfirst($client->user_plus['up_city']) }} , 
						{{{ isset($country->country_name) ? $country->country_name : '' }}}
					</li>
					<li>
						<i class="fa-briefcase"></i>
						<a href="#">{{ ucfirst($client->user_plus['up_company_name']) }}</a>
					</li>
				
				</ul>	
				<hr />

				<script type="text/javascript">
					$(document).ready(function(){
						var maxLength = 100;
						var removedStr ='';
						$(".show-read-more").each(function(){
							var myStr = $(this).text();
							if($.trim(myStr).length > maxLength){
								var newStr = myStr.substring(0, maxLength);
								removedStr = myStr.substring(maxLength, $.trim(myStr).length);
								$(this).empty().html(newStr);
								$(this).append('<a href="javascript:void(0);" class="read-more" style="float:right;"><br />{{$dictionary["more"]}}...</a>');
								//$(this).append('<span class="more-text">' + removedStr + '</span>');
							}
						});
						//$(".read-more").click(function(){
						$(".show-read-more").on("click", ".read-more",function() {
							//$(this).siblings(".more-text").contents().unwrap();
							$(".show-read-more").append('<span class="more-text">' + removedStr + '</span>');
							$(".show-read-more").append('<a href="javascript:void(0);" class="read-less" style="float:right;"><br />{{$dictionary["less"]}}...</a>');
							$(this).remove();
						});

						$(".show-read-more").on("click", ".read-less",function() {
							//alert("LESS");
							$(".more-text").remove();
							$(".show-read-more").append('<a href="javascript:void(0);" class="read-more" style="float:right;"><br />{{$dictionary["more"]}}...</a>');
							$(this).remove();
						});
					});
				</script>
				<p class='show-read-more'>
					{{ $client->user_plus['up_about_company']}} 
				</p>
				<div class="clearfix"></div>
				<hr />
				<ul class="list-unstyled user-friends-count">
					<li>
						<span>{{ count($client->product_user) }}</span>
						Products
					</li>
					<li>
						<span>7</span>
						Developments
					</li>
				</ul>
				<!-- <a href="{{url('client/home')}}">
				<button type="button" class="btn btn-primary btn-block text-left" id="client_dash">
					Client Dashboard
					<i class=" fa-dashboard pull-right"></i>
				</button>
				</a> -->
				<a href="{{url('profile')}}/{{$client->id}}">
				<button type="button" class="btn btn-warning btn-block text-left" id="edit_user">
					Edit
					<i style="margin-top:-7%" class="fa-pencil pull-right"></i>
				</button>
				</a>
				<a style="display:none" href="{{url('delete/')}}/{{$client->id}}">
				<button type="Delete" class="btn btn-danger btn-block text-left">
					Delete
					<i style="margin-top:-7%" class="fa-trash pull-right"></i>
				</button>
				</a>
				
			</div>
			
		</div>
		
		<div class="col-sm-9">
			<!-- Bordered + shadow panel -->
			@foreach ($products as $product)	
				<div class="panel panel-default panel-border panel-shadow"><!-- Add class "collapsed" to minimize the panel -->
					<div class="panel-heading">
						<h3 class="panel-title">{{ ucfirst($client->user_plus['up_company_name']) }} - {{ $product['prod_name']}}</h3>
						
						<div class="panel-options">
							
							<a href="#" data-toggle="panel">
								<span class="collapse-icon">&ndash;</span>
								<span class="expand-icon">+</span>
							</a>
							
							
						</div>
					</div>
					
					<div class="panel-body">
						<div class="col-sm-5">
		
							<div class="panel panel-default" style="padding-top:0;">
								
								<div class="panel-body">
									
									<div class="vertical-top">	

									    @foreach ($product['item'] as $key=>$items)	
										@if($permit->{"module_sidebar_".$items['item_name']})
										<a href="{{ url("/".$items['item_url']) }}">
										<button class="btn btn-info btn-block">{{ $dictionary[$items['item_name']] }}</button>				
										</a>
										@endif	
										@endforeach

										
									</div>
									
								</div>
							</div>
							
						</div>
						<div class="col-sm-7">
							<div class="col-sm-6">
							<div class="xe-widget xe-counter xe-counter-info col-sm-6" data-count=".num" data-from="1000" data-to="2470" data-duration="4" data-easing="true">
								<div class="xe-icon">
									<i class="fa-camera"></i>
								</div>
								<div class="xe-label">
									<strong class="num">1200</strong>
									<span>Images</span>
								</div>
							</div>
							<div class="xe-widget xe-counter xe-counter-info col-sm-6" data-count=".num" data-from="1000" data-to="2470" data-duration="4" data-easing="true">
								<div class="xe-icon">
									<i class="fa-star-o"></i>
								</div>
								<div class="xe-label">
									<strong class="num">870</strong>
									<span>Total References</span>
								</div>
							</div>
							<div class="xe-widget xe-counter xe-counter-info col-sm-6" data-count=".num" data-from="1000" data-to="2470" data-duration="4" data-easing="true">
								<div class="xe-icon">
									<i class="fa-star"></i>
								</div>
								<div class="xe-label">
									<strong class="num">800</strong>
									<span>References Written</span>
								</div>
							</div>
							</div>
							<div class="col-sm-6">
							
						
							<div class="xe-widget xe-counter xe-counter-info col-sm-6" data-count=".num" data-from="1000" data-to="2470" data-duration="4" data-easing="true">
								<div class="xe-icon">
									<i class=" fa-upload"></i>
								</div>
								<div class="xe-label">
									<strong class="num">182</strong>
									<span>Files Uploaded</span>
								</div>
							</div>
								<div class="xe-widget xe-counter xe-counter-info col-sm-6" data-count=".num" data-from="1000" data-to="2470" data-duration="4" data-easing="true">
								<div class="xe-icon">
									<i class=" fa-download"></i>
								</div>
								<div class="xe-label">
									<strong class="num">120</strong>
									<span>Files Generated</span>
								</div>
							</div>
							
							</div>

							
						</div>
		
					</div>
				</div>

				@endforeach
			
		</div>
		
	</div>
	
</section>


@endsection