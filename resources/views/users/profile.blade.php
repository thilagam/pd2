@extends('../app')

@section('content')

<script type="text/javascript">

</script>
<section class="profile-env">
				
				<div class="row">
				
					<div class="col-sm-3">
						
						<!-- User Info Sidebar -->
						<div class="user-info-sidebar">
							
							<a href="#" class="user-img">
								<img src="@if($userPlusData->up_profile_image!='') {{ asset('uploads/'.$userPlusData->up_profile_image)}}@else assets/images/user-1.png @endif" alt="user-img" class="img-cirlce img-responsive img-thumbnail" style="height: 200px;
    width: 200px;"  />
							</a>
							
							<a href="#" class="user-name">
								{{$userPlusData->up_first_name}} {{$userPlusData->up_last_name}} 
								<span class="user-status is-online"></span>
							</a>
							
							<span class="user-title">
								{{$userPlusData->up_designation}} <strong>{{$userPlusData->up_company_name}}</strong>
							</span>
								
							<hr />
							
							<ul class="list-unstyled user-info-list">
							<li>
								<i class="fa-home"></i>
								{{$userPlusData->up_city}}, {{$userPlusData->up_country_code}}
							</li>
							<li>
								<i class="fa-briefcase"></i>
								<a href="#">{{$userPlusData->up_company_name}}</a>
							</li>
							
						</ul>	
								
							<hr />
							<ul class="list-unstyled user-friends-count" style="display:none;">
								<li>
									<span>12</span>
									Products
								</li>
								<li>
									<span>28</span>
									Developments
								</li>
							</ul>
                
                        @if($userPlusData->up_user_id == Auth::id())
   						    <a href="{{ url('editProfile')}}">
							<button type="button" class="btn btn-warning btn-block text-left" id="edit_user">
								{{ $dictionary['profile_edit'] }}
								<i class="fa-pencil pull-right" style="margin-top:-7%;"></i>
							</button>
							</a>
							<a style="display:none" onclick="return confirm('Are you sure you want to delete this item?');"  href="{{ route('users.show',$userPlusData->up_user_id) }}">
							<button type="Delete" class="btn btn-danger btn-block text-left">
								{{ $dictionary['profile_delete'] }}
								<i class="fa-trash pull-right"></i>
							</button>
							</a>
						@endif	

						</div>
						
					</div>
					
					<div class="col-sm-9">
						
						@include('users.activities')

					</div>
					
				</div>
				
			</section>

<link rel="stylesheet" href="{{ asset('/assets/js/datatables/dataTables.bootstrap.css') }}">

<script src="{{ asset('/assets/js/datatables/js/jquery.dataTables.min.js') }}"></script>
<!-- Imported scripts on this page -->
<script src="{{ asset('/assets/js/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ asset('/assets/js/datatables/tabletools/dataTables.tableTools.min.js') }}"></script>


@endsection			
