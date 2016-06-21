@extends('../app')
@section('content')
@include('blocks.error_block')

<div class="row">
	<div class="col-sm-12">
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
		 {!! Form::open(['url' => 'client','method'=>'post','id'=>'rootwizard','class'=>'form-wizard validate']) !!}	
			
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
						<strong>{{ $dictionary['cl_personal_info_dtl'] }}</strong>
						<br />
						<br />
						<div class="row">
							
							<div class="col-md-6">
								
								
								 <div class="form-group">
								        {!! Form::label($dictionary['cl_first_name'], $dictionary['cl_first_name']) !!}
								        {!! Form::text('first_name',null,['class'=>'form-control','id'=>'first_name','data-validate'=>'required','placeholder'=>$dictionary['cl_enter_first_name']]) !!}
								 </div>
							</div>
							
							<div class="col-md-6">
								
								<div class="form-group">
								        {!! Form::label($dictionary['cl_last_name'], $dictionary['cl_last_name']) !!}
								        {!! Form::text('last_name',null,['class'=>'form-control','id'=>'last_name','data-validate'=>'required','placeholder'=>$dictionary['cl_enter_last_name']]) !!}
								 </div>
							</div>
							
							
						</div>
						<div class="row">
							
							<div class="col-md-6">
								<!-- <div class="form-group">
									<label class="control-label" for="full_name">Email Id</label>
									<input class="form-control" name="full_name" id="full_name" data-validate="required" placeholder="Valid email Id" />
								</div> -->
								<div class="form-group">
								        {!! Form::label($dictionary['cl_email_address'], $dictionary['cl_email_address']) !!}
								        {!! Form::text('email',null,['class'=>'form-control','id'=>'email','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_email']]) !!}
								 </div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label($dictionary['cl_username'], $dictionary['cl_username']) !!}
									
									<div class="input-group">
										<div class="input-group-addon">
											<i class="linecons-user"></i>
										</div>
										{!! Form::text('name',null,['class'=>'form-control','id'=>'name','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_username']]) !!}
										<!-- <input type="text" class="form-control" name="username" id="username" data-validate="required,minlength[8]" data-message-minlength="Username must have minimum of 8 chars." placeholder="Could also be your email" /> -->
									</div>
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
								<!-- <div class="form-group">
									<label class="control-label" for="job_position_1">Company Name</label>
									<input class="form-control" name="job_position_1" id="job_position_1" data-validate="require" placeholder="name" />
								</div> -->
								<div class="form-group">
								        {!! Form::label($dictionary['cl_company_name'], $dictionary['cl_company_name']) !!}
								        {!! Form::text('company_name',null,['class'=>'form-control','id'=>'company_name','data-validate'=>'required','placeholder'=>$dictionary['cl_placeholder_company_name']]) !!}
								 </div>
							</div>
							
							<div class="col-md-4">
							<!-- 	<div class="form-group">
									<label class="control-label" for="job_position_1">Punch line</label>
									<input class="form-control" name="job_position_1" id="job_position_1" data-validate="require" placeholder="(Optional)" />
								</div> -->
								<div class="form-group">
								        {!! Form::label($dictionary['cl_punch_line'], $dictionary['cl_punch_line']) !!}
								        {!! Form::text('punch',null,['class'=>'form-control','id'=>'punch','data-validate'=>'','placeholder'=>$dictionary['cl_placeholder_punch']]) !!}
								 </div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label" for="job_position_start_date_1">{{ $dictionary['cl_city'] }}</label>
									<input class="form-control" name="job_position_start_date_1" id="job_position_" placeholder="(Optional)" />
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
				        							   	null,
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
								<!-- <div class="form-group">
									<label class="control-label" for="about">Write Something About Company</label>
									<textarea class="form-control autogrow" name="about" id="about" data-validate="minlength[10]" rows="5" placeholder="Could be used also as extra information (Optional)"></textarea>

								</div> -->
								<div class="form-group">
								        {!! Form::label($dictionary['cl_about_company'], $dictionary['cl_about_company']) !!}
								        {!! Form::textarea('about_company',null,['class'=>'form-control autogrow','id'=>'user_about_you','rows'=>5,'data-validate'=>'','placeholder'=>$dictionary['cl_placeholder_about_company']]) !!}
								 </div>
							</div>
			
						</div>
						
					</div>
					<div class="tab-pane with-bg" id="fwv-3">
						<strong>{{ $dictionary['cl_products_info_dtl'] }}</strong>
						<br />
						<br />
						<meta name="csrf-token" content="{{ csrf_token() }}" />
						<script type="text/javascript">
							jQuery(document).ready(function($){
								var count=2;
								$('#fwv-3').on("click", ".addProductLine",function() {
								// function addProductLine()
								// {
									//alert('HI');
									var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

									$.ajax({
									    url: '{{url() }}/client/addProductHelper/'+count,
									    type: 'POST',
									    data: {_token: CSRF_TOKEN,id:count},
									    dataType: 'html',
									    success: function (data) {
									    	//alert('success');
									       // console.log(data);
									       $('#fwv-3').append(data);
									     //  $('#boincharge_'.count).data('selectBox-selectBoxIt').refresh();
									       $("#boincharge_"+count).selectBoxIt({
												showFirstOption: false
											}).on('open', function()
											{
												// Adding Custom Scrollbar
												$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
											});

											
										    //$('input[name=result]').val(result);
										    var result = $('[id^=row_]').filter(function () {
										        return this.id.match(/row_\d+$/); //regex for the pattern "Q followed by a number"
										    });
										    var big=0;
											result.each(function() {
											    var rowid=$(this).attr("id");
												rowid=rowid.split('_');
												rowid=rowid[1];
												$("#plus_"+rowid).hide();
												
											});
											$("#plus_"+count).show();

									       count++;
									    }
									});
								// }
								});
								$('#fwv-3').on("click", ".removeProductLine",function() {
									var result = $('[id^=row_]').filter(function () {
										        return this.id.match(/row_\d+$/); //regex for the pattern "Q followed by a number"
										    }).length;
									if(result>1){
										var button_id=this.id;
										var counter=button_id.split("_");
										counter=counter[1];
										//$("#row_"+counter).remove();	
										$("#row_"+counter).hide('slow', function(){ $("#row_"+counter).remove(); });
										//removng 
										var result = $('[id^=row_]').filter(function () {
										        return this.id.match(/row_\d+$/); //regex for the pattern "Q followed by a number"
									    });
									    var big=0;
										result.each(function() {
										    var rowid=$(this).attr("id");
											rowid=rowid.split('_');
											rowid=rowid[1];
											$("#plus_"+rowid).hide();
											if(rowid>=big && rowid!=counter){
												big=rowid;
											}
										});
										$("#plus_"+big).show();
										//alert(big);


									}else{
										alert("connot remove all");
									}
								});
								
							});
						</script>

						<div class="row" id='row_1'>
						
							<div class="col-md-5">
								<div class="form-group">
									{!! Form::label($dictionary['cl_product_name'], $dictionary['cl_product_name'],['class'=>'control-label']) !!}
									
									<input class="form-control" name="product_name[]" id="product_name_1" data-validate="require" placeholder="{{ $dictionary['cl_product_name_placeholder'] }}" />
								</div>
							</div>
							
							<div class="col-md-5">
								<div class="form-group">
									{!! Form::label($dictionary['cl_boincharge'], $dictionary['cl_boincharge'],['class'=>'control-label']) !!}
												
									<script type="text/javascript">
										jQuery(document).ready(function($)
										{
											$("#boincharge_1").selectBoxIt({
												showFirstOption: false
											}).on('open', function()
											{
												// Adding Custom Scrollbar
												$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
											});
										});
									</script>
									{!! Form::select('boincharge[]',
								        			    $bouserData,
				        							   	null,
				        							    [	
				        								'class'=>'form-control',
				        								'id'=>'boincharge_1',
				        								'data-validate'=>'required',
				        								'placeholder'=>'select bouser'
				        							    ]
								        			) 
								        !!}
									<!-- <select  name="boincharge[]" class="form-control" id="boincharge_1">
										<option>Select User Incharge</option>
										<option value="al">Lorna</option>
										<option value="au">Cristelle</option>
										<option value="bd">Alex</option>
										<option value="br">Tiphaine</option>
										
										
									</select> -->
									
								</div>
							</div>

							
							
							<div class="col-md-1"  id="min_1">

								<div class="form-group">
									<label class="control-label" for="job_positi"> &nbsp;</label>
									<button id='remove_1' type="button" class="btn btn-danger btn-single form-control col-md-2 removeProductLine">-</button>
									
								</div>
							</div>
							<div class="col-md-1" id='plus_1'>

								<div class="form-group">
									<label class="control-label" for="job_positi"> &nbsp;</label>
									<button type="button" class="btn btn-info btn-single form-control col-md-2 addProductLine">+</button>
									
								</div>
							</div>
							
						</div>
						
						
						

					</div>
					
					<div class="tab-pane with-bg" id="fwv-4">
									
						<strong>{{ $dictionary['cl_other_info_dtl'] }}</strong>
						<br />
						<br />
						
						<div class="row">
							
							<div class="col-md-6">
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
							<div class="col-md-3">
								<div class="form-group">
								        {!! Form::label(
								        				$dictionary['cl_max_sub_accounts'], 
								        				$dictionary['cl_max_sub_accounts']
								        				) 
								        !!}
								        <script type="text/javascript">
										jQuery(document).ready(function($)
										{
											$("#max_sub_accounts").selectBoxIt({
												showFirstOption: false
											}).on('open', function()
											{
												// Adding Custom Scrollbar
												$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
											});
										});
										</script>
								        {!! Form::select('user_max_sub_accounts',
								        			    $counts,
				        							    null,
				        							    [	
				        								'class'=>'form-control',
				        								'id'=>'max_sub_accounts',
				        								'data-validate'=>'required',
				        								'placeholder'=>$dictionary['cl_placeholder_max_sub_accounts']
				        							    ]
								        			) 
								        !!}
								 </div>
							</div>
							
							<div class="col-md-6">	
								<div class="form-group">
									
									{!! Form::label($dictionary['cl_status'], $dictionary['cl_status'], array('class' => 'control-label')) !!}
									
									<br />
									{!! Form::checkbox('status',1,true,['class'=>'iswitch iswitch-secondary','id'=>'status']) !!}
								    <!-- <input type="checkbox" class="iswitch iswitch-secondary" checked> -->
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
							<a href="#"><i class="entypo-left-open"></i>{{ $dictionary['cl_previous_button'] }}</a>
						</li>
						
						<li class="next">
							<a href="#">{{ $dictionary['cl_next_button'] }}<i class="entypo-right-open"></i></a>
						</li>
					</ul>
					
				</div>
				
			{!! Form::close() !!}
		
	</div>
</div>



<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{ asset('/assets/js/daterangepicker/daterangepicker-bs3..css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2..css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2-bootstrap..css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/multiselect/css/multi-select..css') }}">

	<link rel="stylesheet" href="{{ asset('/assets/js/dropzone/css/dropzone..css') }}">

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
	<script src="{{ asset('/assets/js/xenon-custom.js') }}"></script>

@stop