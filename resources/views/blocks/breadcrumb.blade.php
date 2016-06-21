@if(isset($tn_breadcrumb))
<div class="page-title">

	<div class="title-env">
		<h1 class="title">{{ $dictionary[$tn_breadcrumb['breadcrumb_name']] }}</h1>
		<p class="description"> {{ $dictionary[$tn_breadcrumb['breadcrumb_description']] }} </p>
	</div>

	<div class="breadcrumb-env">

		<ol class="breadcrumb bc-1">
			<li>
				<a href="{{ url('/home')  }}"><i class="fa-home"></i>{{ $dictionary['bd_home'] }}</a>
			</li>

			@if(strpos($tn_breadcrumb['breadcrumb_url'], "/") && strcmp($tn_breadcrumb['modules']['mod_name'],"Profile") != 0)
			<li>
					<a href="{{ url('/'.$tn_breadcrumb['modules']['mod_url']) }}{{ (strstr(Request::path(), 'product')) ? "/".trim(preg_replace('/[^0-9]/','',Request::path())) : '' }}">
					{{ $dictionary["bd_".strtolower($tn_breadcrumb['modules']['mod_name'])] }}
					</a>
			</li>
			@endif

		    <li class="active">
				<strong>{{ $dictionary[$tn_breadcrumb['breadcrumb_name']] }}</strong>
			</li>
		</ol>

	</div>

</div>
@endif
