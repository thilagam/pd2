@extends('../app')

@section('content')


<div class="row">
	<div class="col-sm-12">
	<div>
		 @include('blocks.error_block')
	</div>


		<!-- Form wizard with validation starts here -->
		<script type="text/javascript">
				jQuery(document).ready(function($)
				{
					$(".multi-select").multiSelect({
						afterInit: function()
						{
							// Add alternative scrollbar to list
							this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar();
						},
						afterSelect: function()
						{
							// Update scrollbar size
							this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar('update');
						}
					});
					
					$(".selectboxit").selectBoxIt().on('open', function()
					{
						// Adding Custom Scrollbar
						$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
					});
				});
			</script>
			
			<!-- <form role="forl" id="rootwizard" class="form-wizard" novalidate> -->
			 {!! Form::open(['url' => 'doEdit/'.Auth::user()->id ,'method'=>'post','id'=>'rootwizard','class'=>'form-wizard validate']) !!}	
				<ul class="tabs">
					<li class="active">
						<a href="#fwv-1" data-toggle="tab">
							{{ $dictionary['cl_personal_info'] }}
							<span>1</span>
						</a>
					</li>
					
					<li>
						<a href="#fwv-2" data-toggle="tab">
							{{ $dictionary['cl_company_info'] }}
							<span>4</span>
						</a>
					</li>
					<li>
						<a href="#fwv-3" data-toggle="tab">
							{{ $dictionary['cl_products_info'] }}
							<span>4</span>
						</a>
					</li>
					<li>
						<a href="#fwv-4" data-toggle="tab">
							{{ $dictionary['cl_other_info'] }}
							<span>5</span>
						</a>
					</li>
				</ul>
				
				<div class="progress-indicator">
					<span></span>
				</div>
				
				<div class="tab-content no-margin">
					
					<!-- Tabs Content -->
					<div class="tab-pane with-bg active" id="fwv-1">
						
						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group">
								        {!! Form::label($dictionary['cl_first_name'], $dictionary['cl_first_name']) !!}
								        {!! Form::text('first_name',$userPlusData->up_first_name,['class'=>'form-control','id'=>'first_name','data-validate'=>'required','placeholder'=>$dictionary['cl_enter_first_name']]) !!}
								 </div>
								
							</div>
							
							<div class="col-md-6">
								
								<div class="form-group">
								        {!! Form::label($dictionary['cl_last_name'], $dictionary['cl_last_name']) !!}
								        {!! Form::text('last_name',$userPlusData->up_last_name,['class'=>'form-control','id'=>'last_name','data-validate'=>'required','placeholder'=>$dictionary['cl_enter_last_name']]) !!}
								 </div>

							</div>
							
							
						</div>
						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group">
								        {!! Form::label($dictionary['cl_email_address'],$dictionary['cl_email_address']) !!}
								        {!! Form::text('email',$userData->email,['class'=>'form-control','id'=>'email','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_email']]) !!}
								 </div>
							</div>
							
							<div class="col-md-6">
								
								<div class="form-group">
								        {!! Form::label($dictionary['cl_username'], $dictionary['cl_username']) !!}
								        {!! Form::text('name',$userData->name,['class'=>'form-control','id'=>'name','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_username']]) !!}
								 </div>
								
							</div>
							
							
						</div>
						<div class="row">
							
							<div class="col-md-6">
								
								 <div class="form-group">
									<!-- <label class="control-label" for="field-2">Reference File</label> -->
									{!! Form::label($dictionary['cl_gender'], $dictionary['cl_gender']) !!}
									<div>
										<div class="form-block" >
											<div class="col-sm-3" style="padding-left:0;">
											<label>
												<!-- <input type="radio" name="radio-3"class="cbr cbr-secondary"> -->
											
												{!! Form::radio('gender', 1, $userPlusData->up_gender==='1', ['class' => 'cbr cbr-info']) !!}
													{{ $dictionary['cl_gender_male'] }}
											</label>
											</div>
											
											<div class="col-sm-3">
											<label>
												{!! Form::radio('gender', 0, $userPlusData->up_gender==='0' , ['class' => 'cbr cbr-secondary']) !!}
													{{ $dictionary['cl_gender_female'] }}
											</label>
											</div>
											
										</div>
									</div>
								</div>

							</div>
							
						
							<div class="col-md-6">
								
								<div class="form-group">
								        {!! Form::label($dictionary['cl_dob'], $dictionary['cl_dob']) !!}
								        <div class="input-group">
								        	{!! Form::text('dob',$userPlusData->up_dob,['class'=>'form-control datepicker','id'=>'dob','data-format'=>'D, dd MM yyyy','placeholder'=>$dictionary['cl_placeholder_dob']]) !!}
								        	<div class="input-group-addon">
												<a href="#"><i class="linecons-calendar"></i></a>
											</div>
										</div>
								 </div>
								 <!-- <div class="form-group">
									<label class="col-sm-3 control-label">Date Picker (popup)</label>
									
									<div class="col-sm-9">
										<div class="input-group">
											<input type="text" class="form-control datepicker" data-format="D, dd MM yyyy">
											
											<div class="input-group-addon">
												<a href="#"><i class="linecons-calendar"></i></a>
											</div>
										</div>
									</div>
								</div> -->

							</div>
							
						</div>
						
						<div class="row">
							
							<div class="col-md-12">
								
								<div class="form-group">
								        {!! Form::label($dictionary['cl_user_about_you'], $dictionary['cl_user_about_you']) !!}
								        {!! Form::textarea('user_about_you',$userPlusData->up_about_user,['class'=>'form-control autogrow','id'=>'user_about_you','rows'=>5,'data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_user_about_you']]) !!}
								 </div>
							</div>
			
						</div>
						
					</div>

					
					<div class="tab-pane with-bg" id="fwv-2">
						
						<strong>{{ $dictionary['cl_company_info_dtl'] }}</strong>
						<br />
						<br />
						
						<div class="row">
						
						
							
							<div class="col-md-4">
								
								<div class="form-group">
								        {!! Form::label($dictionary['cl_company_name'], $dictionary['cl_company_name']) !!}
								        {!! Form::text('company_name',$userPlusData->up_company_name,['class'=>'form-control','id'=>'company_name','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_company_name']]) !!}
								 </div>
							</div>
							
							<div class="col-md-4">
								
								<div class="form-group">
								        {!! Form::label($dictionary['cl_designation'], $dictionary['cl_designation']) !!}
								        {!! Form::text('designation',$userPlusData->up_designation,['class'=>'form-control','id'=>'designation','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_designation']]) !!}
								 </div>
							</div>
							
							<div class="col-md-2">
								
								<div class="form-group">
								        {!! Form::label($dictionary['cl_city'], $dictionary['cl_city']) !!}
								        {!! Form::text('city',$userPlusData->up_city,['class'=>'form-control','id'=>'city','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_city']]) !!}
								 </div>
							</div>
							
							<div class="col-md-2">
								
								<div class="form-group">
								        {!! Form::label(
								        				$dictionary['cl_country'], 
								        				$dictionary['cl_country']
								        				) 
								        !!}
								        <script type="text/javascript">
										jQuery(document).ready(function($)
										{
											$("#country").selectBoxIt({
												showFirstOption: false
											}).on('open', function()
											{
												// Adding Custom Scrollbar
												$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
											});
										});
										</script>
								        {!! Form::select('country',
								        			    $countryData,
				        							    $userPlusData->up_country_code,
				        							    [	
				        								'class'=>'form-control',
				        								'id'=>'country',
				        								'data-validate'=>'required',
				        								'placeholder'=>$dictionary['cl_placeholder_country']
				        							    ]
								        			) 
								        !!}
								 </div>

							</div>
							
						</div>
						<div class="row">
							
							<div class="col-md-12">
								
								<div class="form-group">
								        {!! Form::label($dictionary['cl_about_company'], $dictionary['cl_about_company']) !!}
								        {!! Form::textarea('about_company',$userPlusData->up_about_company,['class'=>'form-control autogrow','id'=>'about_company','rows'=>5,'data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_about_company']]) !!}
								 </div>

							</div>


			
						</div>
						
					</div>
					<div class="tab-pane with-bg" id="fwv-3">
						<div class="panel panel-default">
			
				<div class="panel-heading">
					<h3 class="panel-title">{{ $dictionary['cl_profile_image'] }}	</h3>
				</div>
				
				<div class="panel-body">
					
					<script type="text/javascript">
						var token = "{{ Session::getToken() }}";
						jQuery(document).ready(function($)
						{		
								var i = 1,
								$example_dropzone_filetable = $("#example-dropzone-filetable"),
								example_dropzone = $("#advancedDropzone").dropzone({
								url: '{{ url("userImage")}}',
								uploadMultiple:false,
								maxFiles:1,
								maxfilesexceeded: function(file){

									$('#notice').html('{{ $dictionary['cl_msg_max_file_upload_alert']}}' );
									$('#notice').show();
								},
								addRemoveLinks:true,
								params: {
				                   _token: token
				                },

								
								// Events
								addedfile: function(file)
								{
									if(i == 1)
									{
										$example_dropzone_filetable.find('tbody').html('');
									}
									
									var size = parseInt(file.size/1024, 10);
									size = size < 1024 ? (size + " KB") : (parseInt(size/1024, 10) + " MB");
									
									var $entry = $('<tr>\
													<td class="text-center">'+(i++)+'</td>\
													<td>'+file.name+'</td>\
													<td><div class="progress progress-striped"><div class="progress-bar progress-bar-warning"></div></div></td>\
													<td>'+size+'</td>\
													<td>Uploading...</td>\
												</tr>');
									
									$example_dropzone_filetable.find('tbody').append($entry);
									file.fileEntryTd = $entry;
									file.progressBar = $entry.find('.progress-bar');
								},
								
								uploadprogress: function(file, progress, bytesSent)
								{
									file.progressBar.width(progress + '%');
								},
								
								success: function(file,response)
								{
									file.fileEntryTd.find('td:last').html('<span class="text-success">Uploaded</span>');
									file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-success');
									$('#image').val(response);
									var newurl="{{ url('uploads/')}}/"+response;
									$('#advancedDropzone').css("background-image", "url("+newurl+")");  
								},
								
								error: function(file)
								{
									file.fileEntryTd.find('td:last').html('<span class="text-danger">Failed</span>');
									file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-red');
								}
							});
							
							$("#advancedDropzone").css({
								minHeight: 200
							});
			
						});
					</script>
					
					<br />
					<div class="row">
						<div class="col-sm-3 text-center">
						
							<div id="advancedDropzone" class="droppable-area" style="background-image: url(@if($userPlusData->up_profile_image!=''){{ asset('uploads/'.$userPlusData->up_profile_image)}} @else assets/images/user-1.png @endif);background-repeat: no-repeat;
    background-position: center;background-size: contain;  border: 1px solid black;">
								{{ $dictionary['cl_drop_file_here'] }}
							</div>
							{!! Form::hidden('image',null,['id' => 'image']) !!}
						</div>
						<div class="col-sm-9">
							
							<table class="table table-bordered table-striped" id="example-dropzone-filetable">
								<thead>
									<tr>
										<th width="1%" class="text-center">#</th>
										<th width="50%">{{ $dictionary['cl_img_name'] }}</th>
										<th width="20%">{{ $dictionary['cl_img_upload_progress'] }}</th>
										<th>{{ $dictionary['cl_img_size'] }}</th>
										<th>{{ $dictionary['cl_img_status'] }}</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="5">{{ $dictionary['cl_file_list'] }}</td>
									</tr>
								</tbody>
							</table>
							<div class="alert alert-danger" style="display:none;" id='notice'></div>
							
						</div>
					</div>
					
				</div>
			
			</div>

					</div>
					
					<div class="tab-pane with-bg" id="fwv-4">
									
						
						
						<div class="row">
							
							<div class="col-md-6">
								<!-- <div class="form-group">
									<label class="control-label">Choose Password</label>
									
									<div class="input-group">
										<div class="input-group-addon">
											<i class="linecons-lock"></i>
										</div>
										
										<input type="password" class="form-control" name="password" id="password" data-validate="required" placeholder="Enter strong password" />
									</div>

								</div> -->
								<div class="form-group">
									{!! Form::label($dictionary['cl_choose_password'], $dictionary['cl_choose_password'], array('class' => 'control-label')) !!}
									<div class="input-group">
										<div class="input-group-addon">
											<i class="linecons-lock"></i>
										</div>
										{!! Form::password('password',['class'=>'form-control','id'=>'password','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_password']]) !!}
									</div>
								</div>
								
							</div>
							
							<div class="col-md-6">						
								<!-- <div class="form-group">
									<label class="control-label">Repeat Password</label>
									
									<div class="input-group">
										<div class="input-group-addon">
											<i class="linecons-lock"></i>
										</div>
										
										<input type="password" class="form-control" name="password" id="password" data-validate="required,equalTo[#password]" data-message-equal-to="Passwords doesn't match." placeholder="Confirm password" />
									</div>
								</div> -->
								<div class="form-group">
									{!! Form::label($dictionary['cl_repeated_password'], $dictionary['cl_repeated_password'], array('class' => 'control-label')) !!}
									<div class="input-group">
										<div class="input-group-addon">
											<i class="linecons-lock"></i>
										</div>
										{!! Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_re_password']]) !!}
									</div>
								</div>
							</div>
							
						</div>
						
						<div class="row">
							
							<div class="col-md-6">	
								<div class="form-group">
									
									{!! Form::label($dictionary['cl_email_address'], $dictionary['cl_email_address'], array('class' => 'control-label')) !!}
									
									<br />
									{!! Form::checkbox('emails',1,$userPlusData->up_email_alerts==='1',['class'=>'iswitch iswitch-secondary','id'=>'emails']) !!}
								    <!-- <input type="checkbox" class="iswitch iswitch-secondary" checked> -->
								</div>
							</div>
							
							<div class="col-md-6">
								
								
								<div class="form-group">
									<!-- <label class="control-label">Alerts</label>
									
									<br />
									
								    <input type="checkbox" class="iswitch iswitch-purple" checked> -->
								    {!! Form::label($dictionary['cl_alerts'], $dictionary['cl_alerts'], array('class' => 'control-label')) !!}
									
									<br />
									{!! Form::checkbox('alerts',1,$userPlusData->up_alerts==='1',['class'=>'iswitch iswitch-purple','id'=>'alerts']) !!}
								    
								</div>
								
								
							</div>
							
						</div>
									
					
						
						<div class="form-group">
							<div class="col-sm-2  pull-right">
								<!-- <button type="button" class="btn btn-info btn-single">Done</button> -->
								{!! Form::submit($dictionary['cl_update_button'], ['class' => 'btn btn-info btn-single']) !!}
							</div>
							<div class="col-sm-2  pull-right">
								<!-- <button type="button" class="btn btn-danger btn-single">Cancel</button> -->
								{!! Form::reset($dictionary['cl_reset_button'], ['class' => 'btn btn-orange btn-single']) !!}
							</div>
							
							
							
						
						</div>
						<div class="clear"></div>
						
					</div>
					
					
					<!-- Tabs Pager -->
					
					<ul class="pager wizard">
						<li class="previous">
							<a href="#"><i class="entypo-left-open"></i> {{ $dictionary['cl_previous_button'] }}</a>
						</li>
						
						<li class="next">
							<a href="#">{{ $dictionary['cl_next_button'] }} <i class="entypo-right-open"></i></a>
						</li>
					</ul>
					
				</div>
				
			{!! Form::close() !!}
		
	</div>
</div>



<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{ asset('/assets/js/daterangepicker/daterangepicker-bs3.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2-bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/multiselect/css/multi-select.css') }}">

	<link rel="stylesheet" href="{{ asset('/assets/js/dropzone/css/dropzone.css') }}">

<!-- Imported scripts on this page -->
	<script src="{{ asset('/assets/js/jquery-validate/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('/assets/js/inputmask/jquery.inputmask.bundle.js') }}"></script>
	<script src="{{ asset('/assets/js/formwizard/jquery.bootstrap.wizard.min.js') }}"></script>
	<script src="{{ asset('/assets/js/datepicker/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('/assets/js/multiselect/js/jquery.multi-select.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('/assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>

	<script src="{{ asset('/assets/js/dropzone/dropzone.min.js') }}"></script>



	<!-- JavaScripts initializations and stuff -->
	<script src="{{ asset('/assets/js/xenon-custom') }}"></script>






@endsection	