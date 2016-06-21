@extends('../app')
@section('content')

<div class="page-error centered">
		
		<div class="error-symbol">
			<i class="fa-warning"></i>
		</div>
		
		<h2>
			{{ $dictionary['error_access_denied'] }}
			<small>{{ $dictionary['error_page_permission_deny'] }}</small>
		</h2>
		
		<p>{{ $dictionary['error_ad_message_1'] }}</p>
		<p>{{ $dictionary['error_ad_message_2'] }}</p>
	</div>
	
	<div class="page-error-search centered">
		<form class="form-half" method="get" action="" enctype="application/x-www-form-urlencoded">
			<input type="text" class="form-control input-lg" placeholder="{{ $dictionary['error_search'] }}" />
			
			<button type="submit" class="btn-unstyled">
				<i class="linecons-search"></i>
			</button>
		</form>
		
	</div>


@stop
