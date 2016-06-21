                        <!-- Add class "collapsed" to minimize the panel -->
		
        <meta name="_token" content="{{ csrf_token() }}"/>
		<div class="panel-heading">
			<h3 class="panel-title">{{ $dictionary['prd_item_update_heading'] }}</h3>
				<div class="panel-options">
	                <a href="#" data-toggle="panel">
						<span class="collapse-icon">&ndash; </span>
						<span class="expand-icon">+</span>
					</a>
				</div>
		</div>
		<div class="panel-body">
			 {!! Form::model($item,['method' => 'PATCH','route'=>['items.update',$item->item_id],'class'=>'form-horizontal']) !!}
		   		   
		     {!! Form::hidden('item_product_id',$item->item_product_id) !!}
		     {!! Form::hidden('pconf_id',$item->pconf_id) !!} 
				<div class="col-sm-6">
			        <div class="panel panel-default" style="padding-top:0;">
					    <div class="panel-body">
							<div class="vertical-top">
							    <div class="form-group">
								{!! Form::label($dictionary['prd_item_name'], $dictionary['prd_item_name'],['class'=>'col-sm-3 control-label']) !!}
										<div class="col-sm-9">
										<script type="text/javascript">
											jQuery(document).ready(function($)
												{
													$("#item_name_type").selectBoxIt({
														showFirstOption: false
													}).on('open', function()
													{
														// Adding Custom Scrollbar
														$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
														});
													});
										</script>

								{!! Form::select('item_name', array('link_pdn' => $dictionary['link_pdn'], 'link_ref' => $dictionary['link_ref'], 'link_ftp_references' => $dictionary['link_ftp_references'], 'link_delivery'=>$dictionary['link_delivery'],'link_writer'=>$dictionary['link_writer']),$item->item_name, ['class'=>'form-control']) !!}

								</div>
								</div>
								<div class="form-group">
								 {!! Form::label($dictionary['prd_item_info'], $dictionary['prd_item_info'],['class'=>'col-sm-3 control-label']) !!}
										<div class="col-sm-9">
                  {!! Form::textarea('item_info',null,['class'=>'form-control','rows'=>4,'placeholder'=>$dictionary['prd_item_info_placeholder']]) !!}
										</div>
								</div>

                                                                <div class="form-group">
                                                                 {!! Form::label($dictionary['prd_item_url'], $dictionary['prd_item_url'],['class'=>'col-sm-3 control-label']) !!}
                                                                                <div class="col-sm-9">
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
 @if($ref_file == 1)														
		{!! Form::radio('ref_file',1,1, ['class' => 'cbr cbr-secondary']) !!}
		{{ strtoupper($dictionary['yes']) }}
 @else
 		{!! Form::radio('ref_file',1,0, ['class' => 'cbr cbr-secondary']) !!}
		{{ strtoupper($dictionary['yes']) }}
 @endif		

				
													</label>
												</div>
												<div class="col-sm-4">
													<label>
 @if($ref_file == 0)	
        {!! Form::radio('ref_file',0,1, ['class' => 'cbr cbr-danger']) !!}
        {{ strtoupper($dictionary['no']) }}
 @else
        {!! Form::radio('ref_file',0,0, ['class' => 'cbr cbr-danger']) !!}
        {{ strtoupper($dictionary['no']) }} 
 @endif

														</label>
												</div>
															
											</div>
										</div>
								</div>
						<div id="referenceFileDiv" @if($ref_file == 0) style="display:none" @endif>
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
											   @if($item->pconf_reference_id == $i)
											        <option selected value="{{ $i }}">{{ chr($i+64) }}</option>
											   @else
													<option value="{{ $i }}">{{ chr($i+64) }}</option>
											   @endif     
											@endfor
										</select>
									</div>
							</div>
							<div class="form-group">
	{!! Form::label($dictionary['prd_item_template'], $dictionary['prd_item_template'],['class'=>'col-sm-2 control-label']) !!}
									<div class="col-sm-10">

											
												<!-- <label class="myFile">
												<div class="btn btn-primary btn-icon btn-icon-standalone">
												<i class="fa-upload"></i>
												<input type="file" value="template" class="btn btn-default" id="field-1" placeholder="upload">
												{!! Form::file('file','',['class'=>'','id'=>'template','placeholder'=>$dictionary['placeholder_upload']]) !!}
												<span>Upload </span>
												</div>
												</label> -->
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
												<script type="text/javascript">
												   $(document).on('change', '.btn-file :file', function() {
													  var input = $(this),
													      numFiles = input.get(0).files ? input.get(0).files.length : 1,
													      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
													  	  input.trigger('fileselect', [numFiles, label]);
													});

												   $(document).ready( function() {
													    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
													        
													        var input = $(this).parents('.input-group').find(':text');
													            log = numFiles > 0 ? numFiles + ' files selected' : label;
													        
													        if( input.length ) {
													            input.val(log);
													        } else {
													            if( log )  alert(log);
													        }
													        
													    });
													});

													
												</script>
												 <div class="input-group">
													<span class="input-group-btn">
									                    <span class="btn btn-primary btn-file">
									                      {{ $dictionary['upload']}}
									                      <!-- <input type="file" multiple> -->
									                      {!! Form::file('file') !!}
													
									                    </span>
									                
									               
														</span>		  
														 <!-- <input type="text" class="form-control" readonly> -->
									                {!! Form::text('item_file_name',null,['class'=>'form-control','placeholder'=>$dictionary['prd_placeholder_upload'],'readonly']) !!}
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

        <a class="btn btn-purple item-create">{{ $dictionary['prd_item_button_back'] }}</a>
        {!! Form::submit($dictionary['prd_item_button_update'], ['class' => 'btn btn-info btn-single pull-right']) !!} 
        {!! Form::reset($dictionary['prd_item_button_reset'], ['class' => 'btn btn-orange btn-single pull-right pull_right_margin']) !!}
 
					</div>
				</div>
		     {!! Form::close() !!}
	    </div>
<script>
$("document").ready(function(){
    $(".item-create").on('click',function(){ 
          $( ".edit-div").load('/items/create?pid={{ $item->item_product_id }}');
    }); 
});    
</script>
