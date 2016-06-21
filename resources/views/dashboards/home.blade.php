@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-body">

<!-- DashBoard Content -->

<div class="row">

				<div class="col-sm-3">

					<div class="xe-widget xe-counter xe-counter-blue" data-count=".num" data-from="0" data-to="{{ $statDetails['user']['total'] }}" data-suffix="" data-duration="3" data-easing="false">
						<div class="xe-icon">
							<i class="linecons-user"></i>
						</div>
						<div class="xe-label">
						   <a href="{{ url('/users') }}">
							<strong class="num">{{ $statDetails['user']['total'] }}</strong>
							<span>Users Total</span>
						   </a>
						</div>
					</div>

				</div>

				<div class="col-sm-3">

					<div class="xe-widget xe-counter" data-count=".num" data-from="0" data-to="{{ $statDetails['product']['total'] }}" data-suffix="" data-duration="2">
						<div class="xe-icon">
							<i class="linecons-cloud"></i>
						</div>
						<div class="xe-label">
							<a href="#">
							<strong class="num">{{ $statDetails['product']['total'] }}</strong>
							<span>Product Total</span>
							</a>
						</div>
					</div>

				</div>

				<div class="col-sm-3">

					<div class="xe-widget xe-counter xe-counter-info" data-count=".num" data-from="0" data-to="{{ $statDetails['item']['total'] }}" data-duration="4" data-easing="true">
						<div class="xe-icon">
							<i class="linecons-camera"></i>
						</div>
						<div class="xe-label">
						    <a href="#">
							<strong class="num">{{ $statDetails['item']['total'] }}</strong>
							<span>Item Total</span>
							</a>
						</div>
					</div>

				</div>

				<div class="col-sm-3">

					<div class="xe-widget xe-counter xe-counter-red" data-count=".num" data-from="0" data-to="{{ $statDetails['crud']['total'] }}" data-prefix="" data-suffix="" data-duration="5" data-easing="true" data-delay="1">
						<div class="xe-icon">
							<i class="linecons-lightbulb"></i>
						</div>
						<div class="xe-label">
							<strong class="num">{{ $statDetails['crud']['total'] }}</strong>
							<span>Crud Tools</span>
						</div>
					</div>

				</div>

				<div class="col-sm-3">

					<div  class="xe-widget xe-counter-block xe-counter-block-blue" data-suffix="" data-count=".num" data-from="0" data-to="{{ $statDetails['user']['active'] }}" data-duration="4" data-easing="false">
						<div class="xe-upper">

							<div class="xe-icon">
								<i class="linecons-user"></i>
							</div>
							<div class="xe-label">
								<strong class="num">{{ $statDetails['user']['active'] }}</strong>
								<span>Active Users</span>
							</div>

						</div>
						<div class="xe-lower">
							<div class="border"></div>

							<span>Clients :- <b>{{ $statDetails['user']['client'] }}</b></span><br />
							<span>BOUser :- <b>{{ $statDetails['user']['bouser'] }}</b></span><br />
							<span>Product Admin :- <b>{{ $statDetails['user']['product_admin'] }}</b></span><br />
							<span>Client Manager :- <b>{{ $statDetails['user']['client_manager'] }}</b></span><br /><br />

							<span>In-Active :- <b>{{ $statDetails['user']['inactive'] }}</b></span><br />

						</div>
					</div>


					<div class="xe-widget">

					<div class="xe-widget xe-vertical-counter xe-vertical-counter-primary" data-count=".num" data-from="0" data-to="{{ $statDetails['upload']['total'] }}" data-decimal="" data-suffix="" data-duration="2.5">
						<div class="xe-icon">
							<i class="fa fa-cloud-upload"></i>
						</div>

						<div class="xe-label">
							<strong class="num">{{ $statDetails['upload']['total'] }}</strong>
							<span>Document Uploads</span>
						</div>
					</div>

					</div>

				</div>


				<div class="col-sm-3">

					<div style="min-height: 231px;" class="xe-widget xe-counter-block" data-count=".num" data-from="0" data-to="{{ $statDetails['product']['active'] }}" data-suffix="" data-duration="2">
						<div class="xe-upper">

							<div class="xe-icon">
								<i class="linecons-cloud"></i>
							</div>
							<div class="xe-label">
								<strong class="num">{{ $statDetails['product']['active'] }}</strong>
								<span>Active Product</span>
							</div>

						</div>

						<div class="xe-lower">
							<div class="border"></div>

							<span>In-Active :- <b>{{ $statDetails['product']['inactive'] }}</b></span><br />

						</div>
					</div>


					<div class="xe-widget">

					<div class="xe-widget xe-vertical-counter xe-vertical-counter-danger" data-count=".num" data-from="0" data-to="{{ $statDetails['download']['total'] }}" data-decimal="" data-suffix="" data-duration="3">
						<div class="xe-icon">
							<i class="fa fa-cloud-download"></i>
						</div>

						<div class="xe-label">
							<strong class="num">{{ $statDetails['download']['total'] }}</strong>
							<span>Document Downloads</span>
						</div>
					</div>

					</div>

				</div>

				<div class="col-sm-3">

					<div style="min-height: 231px;" class="xe-widget xe-counter-block xe-counter-block-purple" data-count=".num" data-from="0" data-to="{{ $statDetails['item']['active'] }}" data-duration="3">
						<div class="xe-upper">

							<div class="xe-icon">
								<i class="linecons-camera"></i>
							</div>
							<div class="xe-label">
								<strong class="num">{{ $statDetails['item']['active'] }}</strong>
								<span>Active Item</span>
							</div>

						</div>
						<div class="xe-lower">
							<div class="border"></div>

							@foreach($statDetails['item']['category'] as $itc)
									<span>{{ $itc['item_name'] }} :- <b>{{ $itc['item_count'] }}</b></span><br />
							@endforeach

								<br /><span>In-Active :- <b>{{ $statDetails['item']['inactive'] }}</b></span><br />

						</div>
					</div>

				</div>


				<div class="col-sm-3">

					<div style="min-height: 231px;" class="xe-widget xe-counter-block xe-counter-block-orange">
						<div class="xe-upper">

							<div class="xe-icon">
								<i class="fa-life-ring"></i>
							</div>
							<div class="xe-label">
								<strong class="num">ALL</strong>
								<span>Listed Below</span>
							</div>

						</div>
						<div class="xe-lower">
							<div class="border"></div>
							@foreach($statDetails['crud']['data'] as $cd)
								<span><a href="{{ url('/'.$cd->crud_url) }}"><b>{{ $cd->crud_name }}</b></a></span><br />
							@endforeach
						</div>
					</div>

				</div>


				<div class="clearfix"></div>

			</div>





<!-- Close Dashboard Content -->

				</div>
			</div>
		</div>
	</div>
</div>



	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{ asset('/assets/css/fonts/meteocons/css/meteocons.css') }}"

	<!-- Imported scripts on this page -->
	<script src="{{ asset('/assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
	<script src="{{ asset('/assets/js/jvectormap/regions/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{ asset('/assets/js/xenon-widgets.js') }}"></script>
@endsection
