@extends('app_login')

@section('content')

			<form class="login-form fade-in-effect" role="form" method="POST" action="{{ url('/password/email') }}">
                                    	<div class="login-header">
						<a href="{{ url('/') }}" class="logo">
							<img src="{{ url('assets/images/logo-edit-place.png') }}" alt="" width="180" />
						</a>
	
						<p>Dear user, provide email address to get password reset link</p>
					</div>


						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="control-label">E-Mail Address</label>
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
						</div>

						<div class="form-group">
								<button type="submit" class="btn btn-primary text-left">
									Send Password Reset Link
								</button>
						</div>
			</form>
@endsection
