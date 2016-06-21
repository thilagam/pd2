<nav class="navbar horizontal-menu navbar-fixed-top"><!-- set fixed position by adding class "navbar-fixed-top" -->

		<div class="navbar-inner">

			<!-- Navbar Brand -->
			<div class="navbar-brand">
				
				<a href="{{url('/')}}" class="logo">
					<img src="{{ asset('/assets/images/logo-edit-place.png') }}" width="180" alt="" class="hidden-xs" />
					<img src="{{ asset('/assets/images/logo-edit-place.png') }}" width="180" alt="" class="visible-xs" />
				</a>
				<a href="#" data-toggle="settings-pane" data-animate="true">
					<i class="linecons-cog"></i>
				</a>
			</div>

			<!-- Mobile Toggles Links -->
			<div class="nav navbar-mobile">

				<!-- This will toggle the mobile menu and will be visible only on mobile devices -->
				<div class="mobile-menu-toggle">
					<!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->
					<a href="#" data-toggle="settings-pane" data-animate="true">
						<i class="linecons-cog"></i>
					</a>

					<a href="#" data-toggle="user-info-menu-horizontal">
						<i class="fa-bell-o"></i>
						<span class="badge badge-success">7</span>
					</a>

					<!-- data-toggle="mobile-menu-horizontal" will show horizontal menu links only -->
					<!-- data-toggle="mobile-menu" will show sidebar menu links only -->
					<!-- data-toggle="mobile-menu-both" will show sidebar and horizontal menu links -->
					<a href="#" data-toggle="mobile-menu-horizontal">
						<i class="fa-bars"></i>
					</a>
				</div>

			</div>

			<div class="navbar-mobile-clear"></div>



			<!-- main menu -->

			<ul class="navbar-nav">
				<li>
					<a href="{{ url('/') }}">
						<i class="fa fa-home"></i>
						<span class="title">{{ $dictionary['tn_dashboard'] }}</span>
					</a>

				</li>
				@if($permit->module_user)
				<li>
					<a href="{{ url('users') }}">
						<i class="fa fa-user"></i>
						<span class="title">{{ $dictionary['tn_users'] }}</span>
					</a>
					<ul>
						@if($permit->module_user_create)
						<li>
							<a href="{{ url('users/create') }}">
								<i class="fa fa-plus"></i>
								<span class="title">{{ $dictionary['tn_users_add_new'] }}</span>
							</a>
						</li>
						@endif
						@if($permit->module_user_view)
						<li>
							<a href="{{ url('users') }}">
								<i class="fa fa-list"></i>
								<span class="title">{{ $dictionary['tn_users_list'] }}</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
				@if($permit->module_client)
				<li>
					<a href="{{ url('client') }}">
						<i class="fa fa-star"></i>
						<span class="title">{{ $dictionary['tn_clients'] }}</span>
					</a>
					<ul>
						@if($permit->module_client_new)
						<li>
							<a href="{{ url('client/create') }}">
							<i class="fa fa-plus"></i>
								<span class="title">{{ $dictionary['tn_clients_add_new'] }}</span>
							</a>
						</li>
						@endif
						@if($permit->module_client_view)
						<li>
							<a href="{{ url('client') }}">
								<i class="fa fa-list"></i>
								<span class="title">{{ $dictionary['tn_clients_list'] }}</span>
								<span class="label label-success pull-right">{{  $globalCounts['clientCount'] }} </span>
							</a>
						</li>
						@endif
						<li>
							<a href="{{ url('appointments') }}">
								<i class="fa fa-chain"></i>
								<span class="title">{{ $dictionary['tn_clients_appointments'] }}</span>
							</a>
								<ul>
								     <li><a href="{{ url('/appointments/create/') }}"><i class="fa fa-chain"></i><span class="title">{{ $dictionary['tn_clients_appointments_create'] }}</span></a></li>
								     <li><a href="{{ url('/appointments/') }}"><i class="fa fa-chain"></i><span class="title">{{ $dictionary['tn_clients_appointments_view'] }}</span></a></li>
							    </ul>


						</li>
					</ul>
				</li>
				@endif
				@if($permit->module_setting)
				<li>
					<a href="javascript:void(0)">
						<i class="fa  fa-cog"></i>
						<span class="title">{{ $dictionary['tn_settings'] }}</span>
					</a>
					<ul>
					      @if($permit->module_setting_language)
						<li>
                           				<a href="{{ url('words-dictionary') }}">
							<i class="fa fa-language"></i>
								<span class="title">{{ $dictionary['tn_settings_language'] }}</span>
							</a>
						</li>
					      @endif
                                              @if($permit->module_setting_group_permission || $permit->module_setting_user_permission)
						<li>
						    <a>
							<i class="fa fa-lock"></i>
								<span class="title">{{ $dictionary['tn_settings_permissions'] }}</span>
							</a>
							<ul>
								@if($permit->module_setting_group_permission)
								<li><a href="{{ url('permissions/all/') }}"><i class="fa fa-lock"></i><span class="title">{{ $dictionary['tn_settings_permissions_group'] }}</span></a></li>
								@endif
								@if($permit->module_setting_user_permission)
								<li><a href="{{ url('permissions/users/') }}"><i class="fa fa-lock"></i><span class="title">{{ $dictionary['tn_settings_permissions_user'] }}</span></a></li>
								@endif
							</ul>
						</li>
                                              @endif
					        @if($permit->module_setting_group)
						<li>
							<a href="{{ url('groups') }}">
							<i class="fa fa-users"></i>
								<span class="title">{{ $dictionary['tn_settings_groups'] }}</span>
							</a>
						</li>
						@endif

					</ul>
				</li>
				@endif
				<li>
					<a href="{{ url('activities') }}">
						<i class="fa fa-flash"></i>
						<span class="title">{{ $dictionary['tn_activity'] }}</span>
					</a>


				</li>
			</ul>


			<!-- notifications and other links -->
			<ul class="nav nav-userinfo navbar-right">

				<li class="search-form"><!-- You can add "always-visible" to show make the search input visible -->

					<form method="get" action="extra-search.html">
						<input type="text" name="s" class="form-control search-field" placeholder="{{ $dictionary['tn_search'] }}" />

						<button type="submit" class="btn btn-link">
							<i class="linecons-search"></i>
						</button>
					</form>

				</li>

			   @if($permit->module_mailbox)
				<li class="dropdown xs-left">
					<a href="#" data-toggle="dropdown" class="notification-icon">
						<i class="fa-envelope-o"></i>
						@if($tn_messages['msg_count'] > 0)
						   <span class="badge badge-green">{{ $tn_messages['msg_count'] }}</span>
						@endif
					</a>

					<ul class="dropdown-menu messages">
										<li>

					    @if($tn_messages['msg'])

						<ul class="dropdown-menu-list list-unstyled ps-scrollbar">

 					      @foreach($tn_messages['msg'] as $emsg)

							<li class="active"><!-- "active" class means message is unread -->
								<a href="{{ url('/mailbox/'.$emsg->em_id.'/message/inbox') }}">
									<span class="line">
										<strong>{{ $emsg->em_subject }}</strong>

									</span>

									<span class="line desc small">
										{{ str_limit(strip_tags($emsg->em_message), $limit = 200, $end = '...') }}
									</span>

									<span class="line light small pull-right"> {{ $emsg->em_dt }}</span>

								</a>
							</li>

						  @endforeach

						</ul>

						@endif

					</li>


					<li class="external">
						<a href="{{ url('mailbox') }}">
							<span>{{ $dictionary['tn_message_all'] }}</span>
							<i class="fa-link-ext"></i>
						</a>
					</li>
					</ul>

				</li>
				@endif


				<li class="dropdown xs-left">
					<a href="#" data-toggle="dropdown" class="notification-icon notification-icon-messages" style="display:none">
						<i class="fa-bell-o"></i>
						<span class="badge badge-purple">7</span>
					</a>

					<ul class="dropdown-menu notifications">
										<li class="top">
						<p class="small">
							<a href="#" class="pull-right">Mark all Read</a>
							You have <strong>3</strong> new notifications.
						</p>
					</li>

					<li>
						<ul class="dropdown-menu-list list-unstyled ps-scrollbar">
							<li class="active notification-success">
								<a href="#">
									<i class="fa-user"></i>

									<span class="line">
										<strong>New user registered</strong>
									</span>

									<span class="line small time">
										30 seconds ago
									</span>
								</a>
							</li>

						</ul>
					</li>

					<li class="external">
						<a href="#">
							<span>View all notifications</span>
							<i class="fa-link-ext"></i>
						</a>
					</li>
					</ul>
				</li>

				@if($permit->module_setting_crud_tools)
				<li class="dropdown hover-line">
				   	<a href="#" data-toggle="dropdown" class="notification-icon ">
						<i class="fa fa-spin fa-cog .badge.badge-purple"></i>
					</a>

					<ul class="dropdown-menu user-profile-menu list-unstyled">
						 @foreach($tn_crud as $crud)
						      @if($permit->{"crud_".$crud->crud_url})
                             <li style="padding: 4px 20px 3px;"><a href="{{ url("/".$crud->crud_url) }}"><i class="fa-edit"></i>{{ $dictionary["tn_crud_".$crud->crud_url] }}</a></li>
                            @endif
						 @endforeach
					</ul>
				</li>
				@endif


				<!-- Added in v1.2 -->
					<li class="dropdown hover-line language-switcher">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="{{ url('assets/images/flags/'.strtoupper($default_languages_value_4_view).'.png') }}" alt="flag-{{ $default_languages_value_4_view }}" />&nbsp;&nbsp;<i class="fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu languages">
						       @foreach($tn_languages as $lang)
								<li class="active">
                                    <a href="{{ url('languages/set-languages/'.$lang->lang_code)  }}">
                                        <img src="{{ url('assets/images/flags/'.strtoupper($lang->lang_code).'.png') }}" alt="flag-{{ $lang->lang_code  }}" />
                                            {{ $lang->lang_name }}
                                    </a>
                                </li>
						       @endforeach
						</ul>
					</li>

				<li class="dropdown user-profile">
					<a href="#" data-toggle="dropdown">
						<img src="@if($user_profile_image!=''){{ url('uploads/'.$user_profile_image) }} @else {{ asset('/assets/images/user-1.png')}} @endif" alt="user-image" class="img-circle img-inline userpic-32" width="28" height="28" />
						<span>
						        {{ Auth::user()->name }}
							<i class="fa-angle-down"></i>
						</span>
					</a>

					<ul class="dropdown-menu user-profile-menu list-unstyled">


						<li>
							<a href="{{ url('profile')}}/{{ Auth::user()->id }}">
								<i class="fa-user"></i>
								{{ $dictionary['tn_profile'] }}
							</a>
						</li>
						<li>
							<a href="#" data-toggle="chat">
								<i class="fa-info"></i>
								{{ $dictionary['tn_help'] }}
							</a>
						</li>
						<li class="last">
							<a href="{{ url('auth/logout') }}">
								<i class="fa-lock"></i>
								{{ $dictionary['tn_logout'] }}
							</a>
						</li>
					</ul>
				</li>


				<li>
					<a href="#" data-toggle="chat">
						<i class="fa-info"></i>
						Help
					</a>
				</li>


			</ul>

		</div>

	</nav>

	<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
