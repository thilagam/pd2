@extends('app_login')

@section('content')

{{ public_path() }}
		<form id="login" class="login-form fade-in-effect" role="form" method="POST" action="{{ url('/auth/login') }}">

                			<div class="login-header">
						<a href="" class="logo">
							<img src="{{ url('assets/images/logo-edit-place.png') }}" alt="width:180" />
						</a>
	
						<p>{{ $dictionary['lg_heading_title']  }}</div>

					<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="control-label">{{ $dictionary['lg_email_address']  }}</label>
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
						</div>

						<div class="form-group">
							<label class="control-label">{{ $dictionary['lg_password']  }}</label>
								<input type="password" class="form-control" name="password">
						</div>

						<div class="form-group">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember">{{ $dictionary['lg_remember_me'] }}
									</label>
								</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary text-left">
							    <i class="fa-lock"></i>{{ $dictionary['lg_login_button'] }}
							</button>
							
						</div>

						<div class="login-footer">
						<a href="{{ url('/password/email') }}">{{ $dictionary['lg_forgot_password'] }}</a>
	
						<div class="info-links">
							<a href="#">{{ $dictionary['lg_tos'] }}</a> -
							<a href="#">{{ $dictionary['lg_privacy_policy'] }}</a>
						</div>
	
					        </div>
		</form>
@endsection
