@extends('../app')

@section('content')

<div class="row">
	<div class="col-md-12">
		 @include('blocks.error_block')
	</div>
	<div class="col-md-12">

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#all" data-toggle="tab">{{ $dictionary['prd_tab_product_home'] }}</a>
			</li>
			@if($permit->module_product_activity)
			<li>
				<a  href="#act" data-toggle="tab">{{ $dictionary['prd_tab_product_activity'] }}</a>
			</li>
			@endif
			 @if($permit->module_product_items)
			<li>
				<a href="#item" data-toggle="tab">{{ $dictionary['prd_tab_product_items'] }}</a>
			</li>
			@endif
			@if($permit->module_product_config_devsa)
			<li>
				<a href="#conf" data-toggle="tab">{{ $dictionary['prd_tab_product_configuration'] }}</a>
			</li>
			@endif
			@if($permit->module_product_config_client)
			<li>
				<a href="#confClient" data-toggle="tab">{{ $dictionary['prd_tab_product_client_configuration'] }}</a>
			</li>
			@endif
			@if($permit->module_product_config_bo)
			<li>
				<a href="#confBo" data-toggle="tab">{{ $dictionary['prd_tab_product_bo_configuration'] }}</a>
			</li>
			@endif
			@if($permit->module_product_config_developer)
			<li>
				<a href="#developerConfig" data-toggle="tab">{{ $dictionary['prd_tab_developer_configuration'] }}</a>
			</li>
			@endif

			@if($permit->module_product_config_item)
			<li>
				<a href="#itemConfig" data-toggle="tab">{{ $dictionary['prd_tab_item_configuration'] }}</a>
			</li>
			@endif


		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="all">

				<section class="profile-env">

					<div class="row">

						<div class="col-sm-3">

							<!-- User Info Sidebar -->
							<div class="user-info-sidebar">


								<a href="#" class="user-name">
									{{ $product->name}}
									<span class="user-status is-online"></span>
								</a>

								<span class="user-title">
									Product for <strong>{{ $product->company}}</strong>
								</span>
								<script type="text/javascript">
									$(document).ready(function(){

										var maxLength = 100;
										var removedStr ='';
										$(".show-read-more").each(function(){
											var myStr = $(this).text();
											if($.trim(myStr).length > maxLength){
												var newStr = myStr.substring(0, maxLength);
												removedStr = myStr.substring(maxLength, $.trim(myStr).length);
												$(this).empty().html(newStr);
												$(this).append('<a href="javascript:void(0);" class="read-more" style="float:right;"><br />{{$dictionary["more"]}}...</a>');
												//$(this).append('<span class="more-text">' + removedStr + '</span>');
											}
										});
										//$(".read-more").click(function(){
										$(".show-read-more").on("click", ".read-more",function() {
											//$(this).siblings(".more-text").contents().unwrap();
											$(".show-read-more").append('<span class="more-text">' + removedStr + '</span>');
											$(".show-read-more").append('<a href="javascript:void(0);" class="read-less" style="float:right;"><br />{{$dictionary["less"]}}...</a>');
											$(this).remove();
										});

										$(".show-read-more").on("click", ".read-less",function() {
											//alert("LESS");
											$(".more-text").remove();
											$(".show-read-more").append('<a href="javascript:void(0);" class="read-more" style="float:right;"><br />{{$dictionary["more"]}}...</a>');
											$(this).remove();
										});
									});
								</script>
								<hr />
									<p class='show-read-more'>
										{{ $product->description}}
									</p>
									<div class="clearfix"></div>
								<hr />

								<ul class="list-unstyled user-info-list">
								<li>
									<span class="user-title">
										{{ $dictionary['prd_product_admin'] }} <strong>{{ $productUsers->admin}}</strong>
									</span>
								</li>
								<li>
									<span class="user-title">
										{{ $dictionary['prd_product_incharge'] }} <strong>{{ $productUsers->incharge}}</strong>
									</span>
									<span class="user-title">
										{{ $dictionary['prd_product_incharge_2'] }} <strong>Tiphaine</strong>
									</span>
								</li>

								</ul>
								<hr />
									<span class="user-title">
										<strong>{{ $dictionary['prd_cl_mail_list'] }}</strong>
									</span>
									@foreach($mailingList as $item)
									<span class="user-title">
										{{ $item->ml_email }}
									</span>
									@endforeach

								<hr />
								<ul class="list-unstyled user-friends-count">
									<li>
										<span>1200</span>
										{{ $dictionary['prd_product_images_count'] }}
									</li>
									<li>
										<span>680</span>
										{{ $dictionary['prd_product_ref_count'] }}
									</li>
								</ul>

							</div>

						</div>

						<div class="col-sm-9">
							<div class="panel panel-default panel-border panel-shadow"><!-- Add class "collapsed" to minimize the panel -->
							<div class="panel-heading">
								<h3 class="panel-title">{{ $dictionary['prd_product_links'] }}</h3>

								<div class="panel-options">

									<a href="#" data-toggle="panel">
										<span class="collapse-icon">&ndash;</span>
										<span class="expand-icon">+</span>
									</a>


								</div>
							</div>

							<div class="panel-body">



							@foreach($allProductItems as $items)
							    <div class="col-sm-6">
								 <a href="{{ url('/'.$items->item_url) }}" class="btn btn-info btn-block">{{ $dictionary[$items->item_name] }}</a>
								</div>
							@endforeach
							</div>
						</div>
						<div class="panel panel-default panel-border panel-shadow"><!-- Add class "collapsed" to minimize the panel -->
							<div class="panel-heading">
								<h3 class="panel-title">{{ $dictionary['prd_product_search'] }}</h3>

								<div class="panel-options">

									<a href="#" data-toggle="panel">
										<span class="collapse-icon">&ndash;</span>
										<span class="expand-icon">+</span>
									</a>


								</div>
							</div>

							<div class="panel-body">
								<div class="col-sm-6">

									<div class="panel panel-default" style="padding-top:0;">

										<div class="panel-body">

											<div class="vertical-top">
												<div class="form-group">
													<label class="control-label" for="field-1">{{ $dictionary['prd_product_single_ref_search'] }}</label>
												</div>
												<div class="form-group">

													<input type="text" class="form-control" id="field-1" placeholder="Reference ">


												</div>
												<div class="form-group">
													<a href="view_refs_image.php" target="_blank">
														<button class="btn btn-info btn-block">{{ $dictionary['prd_search'] }}</button>
														</a>
												</div>


											</div>

										</div>
									</div>

								</div>
								<div class="col-sm-6">

									<div class="panel panel-default" style="padding-top:0;">

										<div class="panel-body">

											<div class="vertical-top">
												<div class="form-group">
													<label class="control-label" for="field-1">{{ $dictionary['prd_upload_file_search'] }}</label>
												</div>
												<div class="form-group">

													<input type="file" class="btn btn-default" id="field-1" placeholder="{{ $dictionary['prd_reference'] }}">


												</div>
												<div class="form-group">
														<button class="btn btn-info btn-block">{{ $dictionary['prd_search'] }}</button>
												</div>


											</div>

										</div>
									</div>

								</div>



							</div>
						</div>

						</div>

					</div>

				</section>

				<div class="clearfix"></div>
			</div>


			@if($permit->module_product_config_developer)
				<div class="tab-pane" id="developerConfig">
				  @include('product.developer_config')
				</div>
			@endif

			@if($permit->module_product_config_item)
				<div class="tab-pane" id="itemConfig">
				  @include('product.item_config')
				</div>
			@endif

			@if($permit->module_product_activity)
				<div class="tab-pane" id="act">
				  @include('product.activities')
				</div>
			@endif
			@if($permit->module_product_items)
			      <div class="tab-pane " id="item">
				     @include('product.items')
				  </div>
			@endif
			@if($permit->module_product_config_devsa)
			<div class="tab-pane " id="conf">
				<div class="col-sm-12">
					<div class="panel panel-default">

						<div class="panel-body">
							<!-- <form role="form" class="form-horizontal" role="form"> -->
							{!! Form::open(['url' => 'product/configs/'.$product->id,'method'=>'post','id'=>'productConfig','class'=>'form-horizontal','enctype'=>'multipart/form-data']) !!}


								<!--Group start-->
								<h3 class="panel-title">{{ $dictionary['prd_ftp'] }}</h3><br>
								<div class="form-group-separator"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="field-2"></label>

									<div class="col-sm-10">
										<div class="form-block">
											<div class="col-sm-2">
											<!-- $userPlusData->up_gender==='1' -->
											<label>
												{!! Form::radio('ftp', 1,$prodConfigs['ftp']['ftp_status']==='1' , ['class' => 'cbr cbr-secondary']) !!}
												{{ strtoupper($dictionary['yes']) }}
											</label>
											</div>

											<div class="col-sm-2">
											<label>
												{!! Form::radio('ftp',0, $prodConfigs['ftp']['ftp_status']==='0' , ['class' => 'cbr cbr-danger']) !!}
												{{ strtoupper($dictionary['no']) }}
											</label>
											</div>

										</div>
									</div>
								</div>
								<script type="text/javascript">


									jQuery(document).ready(function($)
									{
										$("input[name=ftp]:radio").change(function () {
											var ftp=$(this).val();
											//alert(ftp);
											if(ftp==1)
											{
												// /alert{'show'};
												$('#ftpDiv').show( "slow", function() {
											    	// Animation complete.
											  	});
											}
											else
											{
												$('#ftpDiv').hide( "slow", function() {
											    	// Animation complete.
											  	});
											}
										});
									});

								</script>
								<div id="ftpDiv" @if($prodConfigs['ftp']['ftp_status']==0) style="display:none;" @endif >
								<div class="form-group">
								        {!! Form::label($dictionary['prd_details'], $dictionary['prd_details'],['class'=>'col-sm-2 control-label']) !!}
								        <div class="col-sm-5">
								        {!! Form::text('host',$prodConfigs['ftp']['ftp_host'],['class'=>'form-control','id'=>'host','data-validate'=>'required','placeholder'=>$dictionary['prd_placeholder_host']]) !!}
								        </div>
								 </div>

								<div class="form-group">
								        {!! Form::label('','',['class'=>'col-sm-2']) !!}
								        <div class="col-sm-5">
								        {!! Form::text('username',$prodConfigs['ftp']['ftp_username'],['class'=>'form-control','id'=>'username','data-validate'=>'required','placeholder'=>$dictionary['prd_placeholder_username']]) !!}
								        </div>
								 </div>
								 <div class="form-group">
								        {!! Form::label('','',['class'=>'col-sm-2']) !!}
								        <div class="col-sm-5">
								        {!! Form::text('password',null,['class'=>'form-control','id'=>'password','data-validate'=>'required','placeholder'=>$dictionary['prd_placeholder_password']]) !!}
								        </div>
								 </div>
								 <div class="form-group">
								        {!! Form::label('','',['class'=>'col-sm-2']) !!}
								        <div class="col-sm-5">
								        {!! Form::text('port',$prodConfigs['ftp']['ftp_port'],['class'=>'form-control','id'=>'port','data-validate'=>'required','placeholder'=>$dictionary['prd_placeholder_port']]) !!}
								        </div>
								 </div>

								 </div>


								<div class="form-group-separator"></div>

								<!--Group end-->

								<!--Group start-->
								<h3 class="panel-title">{{ $dictionary['prd_praise_de_note'] }}</h3><br>
								<div class="form-group-separator"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="field-2"></label>

									<div class="col-sm-10">
										<div class="form-block">
											<div class="col-sm-2">
											<label>
												{!! Form::radio('pdnradio', 1,$prodConfigs['pdn']['pconf_status']==='1' , ['class' => 'cbr cbr-secondary']) !!}
												{{ strtoupper($dictionary['yes']) }}
											</label>
											</div>

											<div class="col-sm-2">
											<label>
												{!! Form::radio('pdnradio', 0,$prodConfigs['pdn']['pconf_status']==='0', ['class' => 'cbr cbr-danger']) !!}
												{{ strtoupper($dictionary['no']) }}
											</label>
											</div>

										</div>
									</div>
								</div>
								<script type="text/javascript">
									jQuery(document).ready(function($)
									{
										$("input[name=pdnradio]:radio").change(function () {
											var pdnradio=$(this).val();
											//alert(ftp);
											if(pdnradio==1)
											{
												// /alert{'show'};
												$('#pdnDiv').show( "slow", function() {
											    	// Animation complete.
											  	});
											}
											else
											{
												$('#pdnDiv').hide( "slow", function() {
											    	// Animation complete.
											  	});
											}
										});
									});

								</script>
								<div id='pdnDiv'  @if($prodConfigs['pdn']['pconf_status']==0) style="display:none;" @endif>
									<div class="form-group">
									        {!! Form::label($dictionary['prd_details'], $dictionary['prd_details'],['class'=>'col-sm-2 control-label']) !!}
									        <div class="col-sm-5">
									        {!! Form::text('path',$prodConfigs['pdn']['pconf_path'],['class'=>'form-control','id'=>'path','data-validate'=>'required','placeholder'=>$dictionary['prd_placeholder_path']]) !!}
									        </div>
									 </div>

									<div class="form-group">
										{!! Form::label('','',['class'=>'col-sm-2']) !!}

										<div class="col-sm-5">
											<script type="text/javascript">
												jQuery(document).ready(function($)
												{
													$("#pdn_ref").selectBoxIt({
														showFirstOption: false
													}).on('open', function()
													{
														// Adding Custom Scrollbar
														$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
													});
												});
											</script>
											{!! Form::select('pdn_ref',
									        			    $alphaRange,
					        							   	$prodConfigs['pdn']['pconf_reference_id'],
					        							    [
					        								'class'=>'form-control',
					        								'id'=>'pdn_ref',
					        								'data-validate'=>'required',
					        								'placeholder'=>$dictionary['placeholder_pdn_ref']
					        							    ]
									        			)
									        !!}


										</div>
									</div>
									<style type="text/css">
										.btn-file {
									        position: relative;
									        overflow: hidden;
									    }
									    .btn-file input[type=file] {
									        position: absolute;
									        top: 0;
									        right: 0;
									        min-width: 100%;
									        min-height: 100%;
									        font-size: 100px;
									        text-align: right;
									        filter: alpha(opacity=0);
									        opacity: 0;
									        outline: none;
									        background: white;
									        cursor: inherit;
									        display: block;
									    }
									</style>
									<div class="form-group">
											<!-- <label class="col-sm-2 control-label" for="field-1">Template</label> -->
	 										{!! Form::label($dictionary['prd_template'], $dictionary['prd_template'],['class'=>'col-sm-2 control-label']) !!}

											<div class="col-sm-5">
												<script type="text/javascript">
												   $(document).on('change', '.btn-file :file', function() {
													  var input = $(this),
													      numFiles = input.get(0).files ? input.get(0).files.length : 1,
													      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
													  input.trigger('fileselect', [numFiles, label]);
													});

												   $(document).ready( function() {
													    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

													        var input = $(this).parents('.input-group').find(':text'),
													            log = numFiles > 1 ? numFiles + ' files selected' : label;

													        if( input.length ) {
													            input.val(log);
													        } else {
													            if( log ) alert(log);
													        }

													    });
													});


												</script>
											    <div class="input-group">
									                <span class="input-group-btn">
									                    <span class="btn btn-primary btn-file">
									                      {{ $dictionary['upload']}}
									                      <!-- <input type="file" multiple> -->
									                      {!! Form::file('pdn_file') !!}

									                    </span>
									                </span>
									                <!-- <input type="text" class="form-control" readonly> -->
									                {!! Form::text('pdn_file_name',null,['class'=>'form-control','placeholder'=>$dictionary['prd_placeholder_upload'],'readonly']) !!}

									            </div>
											</div>

											@if($prodConfigs['pdn']['pconf_template']!='')
											<div class="col-sm-5">
												<span>
													<a href="{{ url('/download/'.Crypt::encrypt($prodConfigs['pdn']['pconf_template']).'/s') }}" class="btn btn-primary btn-icon btn-icon-standalone">
														<i class="fa-download"></i>
													    <span>Download File 2 </span>
													</a>
												</span>
											</div>
											@endif

									</div>
								</div>

								<div class="form-group-separator"></div>
								<!--Group end-->

								<!--Group start-->
								<h3 class="panel-title">Reference File</h3><br>
								<div class="form-group-separator"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="field-2"></label>

									<div class="col-sm-10">
										<div class="form-block">
											<div class="col-sm-2">
											<label>
												{!! Form::radio('refradio', 1,$prodConfigs['ref']['pconf_status']==='1' , ['class' => 'cbr cbr-secondary']) !!}
												{{ strtoupper($dictionary['yes']) }}
											</label>
											</div>

											<div class="col-sm-2">
											<label>
												{!! Form::radio('refradio', 0,$prodConfigs['ref']['pconf_status']==='0', ['class' => 'cbr cbr-danger']) !!}
												{{ strtoupper($dictionary['no']) }}
											</label>
											</div>

										</div>
									</div>
								</div>
								<script type="text/javascript">
									jQuery(document).ready(function($)
									{
										$("input[name=refradio]:radio").change(function () {
											var refradio=$(this).val();
											//alert(ftp);
											if(refradio==1)
											{
												// /alert{'show'};
												$('#refDiv').show( "slow", function() {
											    	// Animation complete.
											  	});
											}
											else
											{
												$('#refDiv').hide( "slow", function() {
											    	// Animation complete.
											  	});
											}
										});
									});

								</script>
								<div id='refDiv' @if($prodConfigs['ref']['pconf_status']==0) style="display:none;" @endif >
								<div class="form-group">
								<!-- 	<label class="col-sm-2 control-label" for="field-1">Details</label>

									<div class="col-sm-5">
										<input type="text" class="form-control" id="field-1" placeholder="Path">
									</div> -->
									{!! Form::label($dictionary['prd_details'], $dictionary['prd_details'],['class'=>'col-sm-2 control-label']) !!}
							        <div class="col-sm-5">
							        {!! Form::text('ref_path',$prodConfigs['ref']['pconf_path'],['class'=>'form-control','id'=>'ref_path','data-validate'=>'required','placeholder'=>$dictionary['placeholder_path']]) !!}
							        </div>


								</div>
								<div class="form-group">
									{!! Form::label('','',['class'=>'col-sm-2']) !!}

									<div class="col-sm-5">
										<script type="text/javascript">
											jQuery(document).ready(function($)
											{
												$("#ref_ref").selectBoxIt({
													showFirstOption: false
												}).on('open', function()
												{
													// Adding Custom Scrollbar
													$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
												});
											});
										</script>
										<!-- {!! Form::select('ref_ref',
								        			    $alphaRange,
				        							   	isset($prodConfigs['ref']['pconf_reference_id']) ? $prodConfigs['ref']['pconf_reference_id'] : 1 ,
				        							    [
				        								'class'=>'form-control',
				        								'id'=>'ref_ref',
				        								'data-validate'=>'required',
				        								'placeholder'=>$dictionary['placeholder_ref_ref']
				        							    ]
								        			)
								        !!} -->

											<select class="form-control" id="ref_ref" name="ref_ref" placeholder="Select Key">
												<option>{{ $dictionary['prd_item_select_key']  }}</option>
												@for($i = 1;$i <= 26;$i++)
														<option value="{{ $i }}" @if(isset($prodConfigs['ref']['pconf_reference_id'] ) && $prodConfigs['ref']['pconf_reference_id'] == $i) selected="selected" @endif >{{ chr($i+64) }}</option>
												@endfor
											</select>

									</div>
								</div>
								<div class="form-group">
										<!-- <label class="col-sm-2 control-label" for="field-1">Template</label> -->
 										{!! Form::label($dictionary['prd_template'], $dictionary['prd_template'],['class'=>'col-sm-2 control-label']) !!}

										<div class="col-sm-5">
											<script type="text/javascript">
												   $(document).on('change', '.btn-file :file', function() {
													  var input = $(this),
													      numFiles = input.get(0).files ? input.get(0).files.length : 1,
													      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
													  input.trigger('fileselect', [numFiles, label]);
													});

												   $(document).ready( function() {
													    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

													        var input = $(this).parents('.input-group').find(':text'),
													            log = numFiles > 1 ? numFiles + ' files selected' : label;

													        if( input.length ) {
													            input.val(log);
													        } else {
													            if( log ) alert(log);
													        }

													    });
													});


												</script>
											    <div class="input-group">
									                <span class="input-group-btn">
									                    <span class="btn btn-primary btn-file">
									                      {{ $dictionary['upload']}}
									                      <!-- <input type="file" multiple> -->
									                      {!! Form::file('ref_file') !!}
									                    </span>
									                </span>
									                <!-- <input type="text" class="form-control" readonly> -->
									                {!! Form::text('ref_file_name',null,['class'=>'form-control','placeholder'=>$dictionary['prd_placeholder_upload'],'readonly']) !!}

									            </div>
										</div>
										@if($prodConfigs['ref']['pconf_template']!='')
											<div class="col-sm-5">
												<span>

													<a href="{{ url('/download/'.Crypt::encrypt($prodConfigs['ref']['pconf_template']).'/s') }}" class="btn btn-primary btn-icon btn-icon-standalone">
														<i class="fa-download"></i>
													    <span>Download File 2 </span>
													</a>
												</span>
											</div>
											@endif

								</div>

								<!--Group end-->
								</div>

								<div class="form-group-separator"></div>
								<div class="form-group">
									{!! Form::label($dictionary['prd_incharge'], $dictionary['prd_incharge'],['class'=>'col-sm-2 control-label']) !!}

									<script type="text/javascript">
										jQuery(document).ready(function($)
										{
											$("#incharge").selectBoxIt({
												showFirstOption: false
											}).on('open', function()
											{
												// Adding Custom Scrollbar
												$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
											});
										});
									</script>
									<div class="col-sm-10">
									{!! Form::select('incharge',
							        			    $bouserData,
			        							   	$productUsers->incharge_id,
			        							    [
			        								'class'=>'form-control',
			        								'id'=>'incharge',
			        								'data-validate'=>'required',
			        								'placeholder'=>$dictionary['placeholder_incharge']
			        							    ]
							        			)
							        !!}
									</div>
								</div>

								<div class="form-group-separator"></div>
								<div class="form-group">
									{!! Form::label($dictionary['prd_product_admin'], $dictionary['prd_product_admin'],['class'=>'col-sm-2 control-label']) !!}

									<script type="text/javascript">
										jQuery(document).ready(function($)
										{
											$("#product_admin").selectBoxIt({
												showFirstOption: false
											}).on('open', function()
											{
												// Adding Custom Scrollbar
												$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
											});
										});
									</script>
									<div class="col-sm-10">
									{!! Form::select('productAdmin',
							        			    $paData,
			        							   	$productUsers->admin_id,
			        							    [
			        								'class'=>'form-control',
			        								'id'=>'product_admin',
			        								'data-validate'=>'required',
			        								'placeholder'=>$dictionary['placeholder_product_admin']
			        							    ]
							        			)
							        !!}
									</div>
								</div>
								<div class="form-group-separator"></div>
								<!-- <div class="form-group">
									<label class="col-sm-2 control-label" for="field-1">Default Revert Time </label>

									<div class="col-sm-10">
										<input type="text" class="form-control" id="field-1" placeholder="In Hours">
									</div>
								</div> -->
								<div class="form-group">
								        {!! Form::label($dictionary['prd_revert_time'], $dictionary['prd_revert_time'],['class'=>'col-sm-2 control-label']) !!}
								        <div class="col-sm-10">
								        {!! Form::text('revert_time',$product->prod_revert_time,['class'=>'form-control','id'=>'revert_time','data-validate'=>'required','placeholder'=>$dictionary['prd_placeholder_revert_time']]) !!}
								        </div>
								 </div>

								<div class="form-group-separator"></div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="field-2"> {{ $dictionary['prd_status'] }}</label>

									<div class="col-sm-10">
										<div class="form-block">

											<label>
												{!! Form::radio('status', 1, $product->prod_status==='1' , ['class' => 'cbr cbr-secondary']) !!}
												{{ strtoupper($dictionary['active']) }}
											</label>

											<br />
											<label>
												{!! Form::radio('status', 0,$product->prod_status==='0', ['class' => 'cbr cbr-danger']) !!}
												{{ strtoupper($dictionary['disabled']) }}
											</label>

										</div>
									</div>
								</div>

								<div class="form-group-separator"></div>
								<div class="form-group">
									<div class="col-sm-2  pull-right">
										<!-- <button type="button" class="btn btn-info btn-single">Done</button> -->
										{!! Form::submit($dictionary['prd_button_update'], ['class' => 'btn btn-info btn-single']) !!}
									</div>
									<div class="col-sm-2  pull-right">
										<!-- <button type="button" class="btn btn-danger btn-single">Cancel</button> -->
										{!! Form::reset($dictionary['prd_button_reset'], ['class' => 'btn btn-orange btn-single']) !!}
									</div>

								</div>
								<div class="clear"></div>
							{!! Form::close() !!}

						 </div>
					</div>
				</div>
				<div class="clearfix"></div>
				<!--Conf End Here -->
			</div>
			@endif
			@if($permit->module_product_config_client)
			<div class="tab-pane " id="confClient">
				<div class="col-sm-12">
					<div class="panel panel-default">

						<div class="panel-body">
							<!-- <form role="form" class="form-horizontal" role="form"> -->
							{!! Form::open(['url' => 'product/clientConfigs/'.$product->id,'method'=>'post','id'=>'productConfig','class'=>'form-horizontal']) !!}
								<!--Group start-->
											<h3 class="panel-title">{{ $dictionary['prd_mailing_list'] }}</h3><br>
											<div class="form-group-separator"></div>

											<div id="fwv-3">
												<meta name="csrf-token" content="{{ csrf_token() }}" />
												
												@if($mailingList->count()==0)
												
												<div id="row_1">
													<div class="form-group">

														{!! Form::label($dictionary['prd_list_email'], $dictionary['prd_list_email'],['class'=>'col-sm-2 control-label']) !!}
														<div class="col-sm-5">
								       						{!! Form::text('emails[]',null ,['class'=>'form-control','id'=>'email_1','data-validate'=>'required','placeholder'=>$dictionary['prd_placeholder_emails']]) !!}
														</div>

														<div class="col-sm-1"  id="min_1">

															<div class="form-group">
																<button id='remove_1' type="button" class="btn btn-danger btn-single form-control col-md-2 removeProductLine">-</button>

															</div>
														</div>

														<div class="col-sm-1" id='plus_1'>

															<div class="form-group">
																<button type="button" class="btn btn-info btn-single form-control col-md-2 addProductLine" style="margin-left:20px;">+</button>
															</div>
														</div>
													</div>
												</div>
												@else
													@foreach ($mailingList as $index => $mails)
														<div id="row_{{ $index+1 }}">
															<div class="form-group">
																<!-- <label class="col-sm-2 control-label" for="field-1">Emails</label>

																<div class="col-sm-5">
																	<input type="text" class="form-control" id="field-1" placeholder="Jaime@lanister.com">
																</div> -->
																{!! Form::label($dictionary['prd_list_email'], $dictionary['prd_list_email'],['class'=>'col-sm-2 control-label']) !!}
																<div class="col-sm-5">
										       						{!! Form::text('emails[]',$mails->ml_email ,['class'=>'form-control','id'=>'email_'.($index+1),'data-validate'=>'required','placeholder'=>$dictionary['prd_placeholder_emails']]) !!}
																</div>

																<div class="col-sm-1"  id="min_{{ $index+1 }}">

																	<div class="form-group">
																		<button id='cannot_{{ $index+1 }}' type="button" class="btn btn-danger btn-single form-control col-md-2 removeProductLine">-</button>

																	</div>
																</div>

																<div class="col-sm-1" id='plus_{{ $index+1 }}'>

																	<div class="form-group">
																		<button type="button" class="btn btn-info btn-single form-control col-md-2 addProductLine" style="margin-left:20px;">+</button>
																	</div>
																</div>
															</div>
														</div>
													@endforeach

												@endif

											</div>

											<!--Group end-->

											<div class="form-group-separator"></div>
											<div class="form-group">
												<!-- <label class="col-sm-2 control-label">Incharge</label> -->
												{!! Form::label($dictionary['prd_incharge'], $dictionary['prd_incharge'],['class'=>'col-sm-2 control-label']) !!}

												<script type="text/javascript">
													jQuery(document).ready(function($)
													{
														$("#clientincharge").selectBoxIt({
															showFirstOption: true
														}).on('open', function()
														{
															// Adding Custom Scrollbar
															$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
														});
													});
												</script>
												<div class="col-sm-10">
												<!-- <select class="form-control" id="sboxit-5">
													<option>Select Client Incharge</option>
													<option value="al">Self</option>
													<option value="al">Jaime</option>
													<option value="au">Tyrion</option>
													<option value="bd">Caercy</option>

												</select> -->
												{!! Form::select('clientIncharge',
								        			    $cmusersArray,
				        							   	$productUsers->clientManagerId,
				        							    [
				        								'class'=>'form-control',
				        								'id'=>'clientincharge',
				        								'data-validate'=>'required',
				        								'placeholder'=>$dictionary['prd_incharge'],
				        							    ]
								        			)
								        		!!}
												</div>
											</div>


											<div class="form-group-separator"></div>


											<div class="form-group">
												<div class="col-sm-2  pull-right">
													<!-- <button type="button" class="btn btn-info btn-single">Done</button> -->
													{!! Form::submit($dictionary['prd_button_update'], ['class' => 'btn btn-info btn-single']) !!}
												</div>
												<div class="col-sm-2  pull-right">
													<!-- <button type="button" class="btn btn-danger btn-single">Cancel</button> -->
													{!! Form::reset($dictionary['prd_button_reset'], ['class' => 'btn btn-orange btn-single']) !!}
												</div>

											</div>
											<div class="clear"></div>
							{!! Form::close() !!}

						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<!--Conf End Here -->
			</div>
			@endif
			@if($permit->module_product_config_bo)
			<div class="tab-pane " id="confBo">
				<div class="col-sm-12">
					<div class="panel panel-default">

						<div class="panel-body">
							<!-- <form role="form" class="form-horizontal" role="form"> -->

							{!! Form::open(['url' => 'product/boConfigs/'.$product->id,'method'=>'post','id'=>'productConfig','class'=>'form-horizontal']) !!}
								<h3 class="panel-title">{{ $dictionary['prd_bo_list'] }}</h3><br>
									<div class="form-group-separator"></div>
									<div class="form-group">
										<!-- <label class="col-sm-2 control-label">Incharge</label> -->
										{!! Form::label($dictionary['prd_bousers'], $dictionary['prd_bousers'],['class'=>'col-sm-2 control-label']) !!}

										<script type="text/javascript">
											jQuery(document).ready(function($)
											{
												$("#bousers").selectBoxIt({
													showFirstOption: false
												}).on('open', function()
												{
													// Adding Custom Scrollbar
													$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
												});
											});
										</script>
										<div class="col-sm-5">

										<!-- <select class="form-control" id="sboxit-5">
											<option>Select Client Incharge</option>
											<option value="al">Self</option>
											<option value="al">Jaime</option>
											<option value="au">Tyrion</option>
											<option value="bd">Caercy</option>

										</select> -->
										{!! Form::select('bousers',
						        			    $cBouserData,
		        							   	null,
		        							    [
		        								'class'=>'form-control',
		        								'id'=>'bousers',
		        								'data-validate'=>'required',
		        								'placeholder'=>$dictionary['prd_bousers']
		        							    ]
						        			)
						        		!!}
										</div>
									</div>

									<div class="form-group-separator"></div>

									<div id="bolistForm">
									@if(!empty($productUsers->bousers))
										@foreach($productUsers->bousers as $bouserKey => $bouserItem)
											<div id="usr_{{$boindex}}">
												<div class="form-group">
													<label class="col-sm-2 control-label" for="prodBoUsers"></label>
													<div class="col-sm-5">
														<input type="hidden" id="usrid_{{$boindex}}" name="prodBoUsersId[]" value="{{ $bouserKey }}">
														<input id="user_{{$boindex}}" class="form-control" type="text" value="{{$bouserItem}}" name="prodBoUsers[]" placeholder="" data-validate="required">
													</div>
													<div id="minus_{{$boindex}}" class="col-sm-1">
														<div class="form-group">
															<button id="rmv_{{$boindex}}" class="btn btn-danger btn-single form-control col-md-2 removeUserLine" type="button">-</button>
														</div>
													</div>
												</div>
											</div>
												{{--*/ $boindex = $boindex + 1 /*--}}
										@endforeach
									@else

									@endif
									</div>
									<div class="form-group-separator"></div>


											<div class="form-group">
												<div class="col-sm-2  pull-right">
													<!-- <button type="button" class="btn btn-info btn-single">Done</button> -->
													{!! Form::submit($dictionary['prd_button_update'], ['class' => 'btn btn-info btn-single']) !!}
												</div>
												<div class="col-sm-2  pull-right">
													<!-- <button type="button" class="btn btn-danger btn-single">Cancel</button> -->
													{!! Form::reset($dictionary['prd_button_reset'], ['class' => 'btn btn-orange btn-single']) !!}
												</div>

											</div>
											<div class="clear"></div>
							{!! Form::close() !!}

						</div>
					</div>
				</div>

				<div class="clearfix"></div>
				<!--Conf End Here -->
			</div>
			@endif
		</div>
	</div>
</div>


<!-- Imported styles on this page -->
<link rel="stylesheet" href="{{ asset('/assets/js/daterangepicker/daterangepicker-bs3.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2-bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/multiselect/css/multi-select.css') }}">

<script type="text/javascript">

	jQuery(document).ready(function($){
		var result = $('[id^=row_]').filter(function () {
				        return this.id.match(/row_\d+$/); //regex for the pattern "Q followed by a number"
	    });
	    //alert(result.length);
	    var big=0;
	    if(result.length>1){
			result.each(function() {
			    var rowid=$(this).attr("id");
				rowid=rowid.split('_');
				rowid=rowid[1];
				$("#plus_"+rowid).hide();

			});
			$("#plus_{{ count($mailingList)}}").show();
			var count={{ count($mailingList)+1}};
		}else{
			var count=2;
		}

		$('#fwv-3').on("click", ".addProductLine",function() {
			//alert(count);
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			//alert("SHIT");
			$.ajax({
			    url: '{{url() }}/client/addMailingListHelper/'+count,
			    type: 'POST',
			    data: {_token: CSRF_TOKEN,id:count},
			    dataType: 'html',
			    success: function (data) {
			    	//alert('success');
			       // console.log(data);
			       $('#fwv-3').append(data);
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
			    },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //alert("Status: " + textStatus); alert("Error: " + errorThrown);
                    $("#ajaxError").append("<p>"+textStatus+"</p>");
                    $("#ajaxError").append("<p>"+errorThrown+"</p>");
                    $("#ajaxError").show();

                }
			});
		// }
		});
		$('#fwv-3').on("click", ".removeProductWarning",function() {
			alert("Edit Allowed only !");
		});
		$('#fwv-3').on("click", ".removeProductLine",function() {
			var result = $('[id^=row_]').filter(function () {
				        return this.id.match(/row_\d+$/); //regex for the pattern "Q followed by a number"
				    }).length;
			//alert(result);

			if(result>1){
				var button_id=this.id;
				var counter=button_id.split("_");
				counter=counter[1];
				//alert(counter);
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

		var accountedUsers=[];
		@if(!empty($productUsers->bousers))
			@foreach($productUsers->bousers as $bouserKey => $bouserItem)
				accountedUsers.push({{$bouserKey}});
			@endforeach
		@endif
		var usrCount=1;
		//alert(accountedUsers);
		$('#bousers').on('change', function() {
			var optionSelected = $("option:selected", this);
	    	var valueSelected = this.value;
	    	//alert(accountedUsers);
	    	//console.log(accountedUsers);
	    	//console.log(valueSelected);
	    	//console.log(accountedUsers.indexOf(parseInt(valueSelected)));
			if(jQuery.inArray(parseInt(valueSelected), accountedUsers ) < 0){
	    		 //alert( optionSelected.text());
	    		 var elm='<div id="usr_'+usrCount+'"><div class="form-group"><label class="col-sm-2 control-label" for="prodBoUsers"></label><div class="col-sm-5"><input type="hidden" id="usrid_'+usrCount+'" name="prodBoUsersId[]" value="'+valueSelected+'"><input id="user_'+usrCount+'" class="form-control" type="text" value="'+optionSelected.text()+'" name="prodBoUsers[]" placeholder="" data-validate="required"></div><div id="minus_'+usrCount+'" class="col-sm-1"><div class="form-group"><button id="rmv_'+usrCount+'" class="btn btn-danger btn-single form-control col-md-2 removeUserLine" type="button">-</button></div></div></div>'
	    		 $('#bolistForm').append(elm);
	    		 accountedUsers.push(valueSelected);
    		}else{
    			//alert(accountedUsers);
    			alert('Bo user already in list');
    		}
    		usrCount++;
		});

		$('#bolistForm').on("click", ".removeUserLine",function() {
			var button_id=this.id;
			var ucounter=button_id.split("_");
			userCounter=ucounter[1];

			accountedUsers.pop($("#usrid_"+userCounter).val());
			//alert(accountedUsers);
			$("#usr_"+userCounter).hide('slow', function(){ $("#usr_"+userCounter).remove(); });

		});

	});


</script>
<!-- Imported scripts on this page -->
<script src="{{ asset('/assets/js/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/assets/js/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('/assets/js/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('/assets/js/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('/assets/js/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>
<script src="{{ asset('/assets/js/tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('/assets/js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('/assets/js/handlebars.min.js') }}"></script>
<script src="{{ asset('/assets/js/multiselect/js/jquery.multi-select.js') }}"></script>


@endsection
