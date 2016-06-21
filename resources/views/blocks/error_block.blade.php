@if (count($errors) > 0)
	<div class="col-md-12 alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>

	</div>
@endif
@if (session('customError'))
	<div class="col-md-12 alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach (session('customError') as $error_item)
				<li>{{ $error_item }}</li>
			@endforeach
		</ul>

	</div>
@endif
	<div id="ajaxError" class="alert alert-danger" style="display:none;">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>

	</div>
@if(session('success'))
	<div class="alert alert-success">
		<strong>hooooray!</strong> Its done<br><br>
		<ul>
			@foreach (session('success') as $success_item)
				<li>{{ $success_item }}</li>
			@endforeach
		</ul>

	</div>
@endif
<div class="clearfix"></div>