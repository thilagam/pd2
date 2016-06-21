<div class="panel-heading">
			<h3 class="panel-title">{{ $dictionary['prd_item_add_heading'] }}</h3>
				<div class="panel-options">
	                <a href="#" data-toggle="panel">
						<span class="collapse-icon">&ndash;</span>
						<span class="expand-icon">+</span>
					</a>
				</div>
		</div>
		<div class="panel-body">
		     {!! Form::open(['url' => 'items','class'=>'form-horizontal']) !!}
		   
		     {!! Form::hidden('item_product_id',$item_product_id) !!} 
				<div class="col-sm-6">
			        <div class="panel panel-default" style="padding-top:0;">
					    <div class="panel-body">
							<div class="vertical-top">
							    <div class="form-group">
								{!! Form::label($dictionary['prd_item_name'], $dictionary['prd_item_name'],['class'=>'col-sm-3 control-label']) !!}
										<div class="col-sm-10">
								{!! Form::text('item_name',null,['class'=>'form-control','placeholder'=>$dictionary['prd_item_name_placeholder']]) !!}
										</div>
								</div>
								<div class="form-group">
								 {!! Form::label($dictionary['prd_item_info'], $dictionary['prd_item_info'],['class'=>'col-sm-3 control-label']) !!}
										<div class="col-sm-10">
                  {!! Form::textarea('item_info',null,['class'=>'form-control','rows'=>4,'placeholder'=>$dictionary['prd_item_info_placeholder']]) !!}
										</div>
								</div>

                                    <div class="form-group">
                                     {!! Form::label($dictionary['prd_item_url'], $dictionary['prd_item_url'],['class'=>'col-sm-3 control-label']) !!}
                                                    <div class="col-sm-10">
{!! Form::text('item_url',null,['class'=>'form-control','placeholder'=>$dictionary['prd_item_url_placeholder']]) !!}
                                                    </div>
                                    </div>

							</div>
						</div>
					</div>
				</div>

								<script type="text/javascript">
									jQuery(document).ready(function($)
									{
										$("input[name=ref_file]:radio").change(function () {
											var bool=$(this).val();
											//alert(bool);
											if(bool==1)
											{
												// /alert{'show'};
												$('#referenceFileDiv').show( "slow", function() {
											    	// Animation complete.
											  	});
											}
											else
											{
												$('#referenceFileDiv').hide( "slow", function() {
											    	// Animation complete.
											  	});
											}
										});
									});

								</script>


				<div class="col-sm-6">
				    <div class="panel panel-default" style="padding-top:0;">
						<div class="panel-body">
							<div class="vertical-top">
								<div class="form-group">
 {!! Form::label($dictionary['prd_item_reference_file'], $dictionary['prd_item_reference_file'],['class'=>'col-sm-2 control-label']) !!}								
										<div class="col-sm-10">
											<div class="form-block">
												<div class="col-sm-4">
													<label>
{!! Form::radio('ref_file',1,1, ['class' => 'cbr cbr-secondary']) !!}
{{ strtoupper($dictionary['yes']) }}
				
													</label>
												</div>
												<div class="col-sm-4">
													<label>

{!! Form::radio('ref_file',0,0, ['class' => 'cbr cbr-danger']) !!}
{{ strtoupper($dictionary['no']) }}

														</label>
												</div>
															
											</div>
										</div>
								</div>
						<div id="referenceFileDiv">
							<div class="form-group">
{!! Form::label($dictionary['prd_item_details'], $dictionary['prd_item_details'],['class'=>'col-sm-2 control-label']) !!} 
							                <div class="col-sm-10">
{!! Form::text('pconf_path',null,['class'=>'form-control','placeholder'=>$dictionary['prd_item_path_placeholder']]) !!}
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="field-1"></label>
									<div class="col-sm-10">
										<script type="text/javascript">
											jQuery(document).ready(function($)
												{
													$("#sboxit-6").selectBoxIt({
														showFirstOption: false
													}).on('open', function()
													{
														// Adding Custom Scrollbar
														$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
														});
													});
										</script>
														
										<select class="form-control" id="sboxit-6" name="pconf_reference_id" placeholder="Select Key">
											<option>{{ $dictionary['prd_item_select_key']  }}</option>
											@for($i = 1;$i <= 26;$i++)
											   <option value="{{ $i }}">{{ chr($i+64) }}</option>
											@endfor
										</select>
									</div>
							</div>
							<div class="form-group">
	{!! Form::label($dictionary['prd_item_template'], $dictionary['prd_item_template'],['class'=>'col-sm-2 control-label']) !!}
								<div class="col-sm-5">

										<div class="col-sm-5">
											<label class="myFile">
											<div class="btn btn-primary btn-icon btn-icon-standalone">
											<i class="fa-upload"></i>
											<input type="file" value="template" class="btn btn-default" id="field-1" placeholder="upload">
											{!! Form::file('file','',['class'=>'','id'=>'template','placeholder'=>$dictionary['placeholder_upload']]) !!}
											<span>Upload </span>
											</div>
											</label>
											
										</div>
								</div>
							</div>
						</div>
					    </div>
					</div>
				</div>
			</div>
			<div class="form-group-separator"></div>
				<div class="form-group">
					<div class="col-sm-12">

        {!! Form::submit($dictionary['prd_item_button_save'], ['class' => 'btn btn-info btn-single pull-right']) !!} 
        {!! Form::reset($dictionary['prd_item_button_reset'], ['class' => 'btn btn-orange btn-single pull-right pull_right_margin']) !!}
 
					</div>
				</div>
		     {!! Form::close() !!}
	    </div>
