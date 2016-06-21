@extends('../app')

@section('content')

<script type="text/javascript">
jQuery(document).ready(function($)
{
	$("#allUsers").dataTable({
	});
	@foreach ($groups as $group)
	$("#{{ $group->group_name }}").dataTable({
	});
	@endforeach
         // Replace checkboxes when they appear
});
</script>
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
                    	<li class="active">
				<a href="#all" data-toggle="tab">{{ $dictionary['us_all_members'] }}</a>
			</li> 
		  
		        @foreach ($groups as $group)
			<li>
				
			        <a href="#{{ $group->group_id }}" data-toggle="tab">{{ $dictionary["us_group_".strtolower($group->group_code)] }}</a>
			</li>

                        @endforeach
		     	
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="all">
              			
				<table class="table table-hover members-table middle-align" id="allUsers">
					<thead>
					<tr>
						<th class="hidden-xs hidden-sm"></th>
                        <th>{{ $dictionary['us_name_role'] }}</th>
                        <th>{{ $dictionary['us_email_address'] }}</th>
                        <th>{{ $dictionary['us_user_id'] }}</th>
                        <th>{{ $dictionary['us_settings'] }}</th>
					</tr>
					</thead>
					<tbody>
			                        @foreach ($users as $user)

					  
						   <tr>
						   <td class="user-image hidden-xs hidden-sm"> 
							  @if($permit->module_user_profile_view)
								<a href="{{ url('profile')}}/{{ $user->id }}">
							  @else
								<a href="#">
							  @endif
									<img src="@if($user->userPlus['up_profile_image']!='') {{ asset('uploads/'.$user->userPlus['up_profile_image'])}}@else assets/images/user-1.png @endif" class="img-circle" alt="user-pic" />
								</a>
							</td>
							<td class="user-name">
                                @if($permit->module_user_profile_view)
									<a href="{{ url('profile')}}/{{ $user->id }}" class="name">
							  	@else
	                                <a class="name">
	                            @endif
								@if(!empty($user->userPlus->up_first_name) || !empty($user->userPlus->up_last_name))
									{{ $user->userPlus->up_first_name }} {{ $user->userPlus->up_last_name }}
								@endif
									- {{ $user->name }} 
								</a><span>{{ $user->groups->group_name }}</span>
							</td>
							<td>{{ $user->email }}</td>
                                                        <td>{{ $user->id }}</td>
							<td class="action-links">
                     @if($permit->module_user_profile_edit)
                     <a href="@if($user->id != Auth::id()) {{ url('/users/'.$user->id.'/edit') }} @else {{ url('editProfile') }} @endif" class="edit">

                     <i class="linecons-pencil"></i>{{ $dictionary['us_edit_profile'] }}</a>@endif
                     @if($permit->module_user_profile_delete)<a onclick="return confirm('Are you sure you want to delete this item?');"  href="{{ route('users.show',$user->id) }}" class="delete"><i class="linecons-trash"></i>{{ $dictionary['us_delete'] }}</a>@endif
							</td>
						   </tr>
				
						@endforeach
					</tbody>
				</table>

			</div>
                          @foreach ($groups as $group)
	                        <div class="tab-pane" id="{{ $group->group_id }}">
                                  <table class="table table-hover members-table middle-align" id="{{ $group->group_name }}">
                                        <thead>
                                        <tr>	
                                        		<th class="hidden-xs hidden-sm"></th>
                                                <th>{{ $dictionary['us_name_role'] }}</th>
                                                <th>{{ $dictionary['us_email_address'] }}</th>
                                                <th>{{ $dictionary['us_user_id'] }}</th>
                                               <th>{{ $dictionary['us_settings'] }}</th>
                                        </tr>   
                                        </thead>
                                        <tbody>
                                                @foreach ($users as $user)
                                                 @if ($user->group_id == $group->group_id)  
                                                   <tr>
                                                   		<td class="user-image hidden-xs hidden-sm">
                                                         @if($permit->module_user_profile_view)
                                                                  <a href="{{ url('profile')}}/{{ $user->id }}">
                                                          @else
                                                               <a class="name">
                                                          @endif
								  <a href="{{ url('profile')}}/{{ $user->id }}">
									<img src="@if($user->userPlus['up_profile_image']!='') {{ asset('uploads/'.$user->userPlus['up_profile_image'])}}@else assets/images/user-1.png @endif" class="img-circle" alt="user-pic" />
								  </a>
								</td>
                                                        <td>
                                                        @if($permit->module_user_profile_view)
							        <a href="{{ url('profile')}}/{{ $user->id }}" class="name">
                                                          @else
                                                               <a class="name">
                                                          @endif
								{{ $user->name }}</a>
							</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->id }}</td>
                                                        <td class="action-links">

                     @if($permit->module_user_profile_edit)
                     <a href="@if($user->id != Auth::id()) {{ url('/users/'.$user->id.'/edit') }} @else {{ url('editProfile') }} @endif" class="edit">

                     <i class="linecons-pencil"></i>{{ $dictionary['us_edit_profile'] }}</a>@endif
                     @if($permit->module_user_profile_delete)<a onclick="return confirm('Are you sure you want to delete this item?');"  href="{{ route('users.show',$user->id) }}" class="delete"><i class="linecons-trash"></i>{{ $dictionary['us_delete'] }}</a>@endif

                                                        </td>
                                                   </tr>
						 @endif
                                                @endforeach
                                        </tbody>
                                </table>
	 
               		       </div>
			 @endforeach
		</div>
	</div>
</div>

<link rel="stylesheet" href="{{ asset('/assets/js/datatables/dataTables.bootstrap.css') }}">

<script src="{{ asset('/assets/js/datatables/js/jquery.dataTables.min.js') }}"></script>
<!-- Imported scripts on this page -->
<script src="{{ asset('/assets/js/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/tabletools/dataTables.tableTools.min.js') }}"></script>


@endsection

