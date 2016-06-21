<div class="tab-pane " id="item">
	<div class="panel panel-default panel-border panel-shadow edit-div"><!-- Add class "collapsed" to minimize the panel -->
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

		     {!! Form::hidden('item_product_id',$product->id) !!}
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

								{!! Form::select('item_name', $item_list,null, ['class'=>'form-control','id'=>'item_name_type']) !!}
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

        {!! Form::submit($dictionary['prd_item_button_save'], ['class' => 'btn btn-info btn-single pull-right']) !!}
        {!! Form::reset($dictionary['prd_item_button_reset'], ['class' => 'btn btn-orange btn-single pull-right pull_right_margin']) !!}

					</div>
				</div>
		     {!! Form::close() !!}
	    </div>
    </div>
		@if(isset($product_items))
						<!-- Bordered + shadow panel -->
        	      @foreach($product_items as $pi)
					<div class="panel panel-default panel-border panel-shadow collapsed"><!-- Add class "collapsed" to minimize the panel -->
						<div class="panel-heading">
							<h3 class="panel-title" style="text-transform:uppercase;">{{ $dictionary[$pi->item_name] }}</h3>

							<div class="panel-options">
                                                                <a onclick="return confirm('Are you sure you want to delete this item?');"  href="{{ url('items/'.$pi->item_id."-".$pi->pconf_id) }}">
                                                                        <i class="fa-trash item_del" id="{{ $pi->item_id  }}"></i>
                                                               </a>
								<a href="javascript:void(0)">
									<i class="fa-pencil item_edit" id="{{ $pi->item_id  }}"></i>
								</a>
								<a href="#" data-toggle="panel">
									<span class="collapse-icon">&ndash;</span>
									<span class="expand-icon">+</span>
								</a>

							</div>
						</div>

						<div class="panel-body">

							<p>{{ $pi->item_info }}</p>
                                                        <p>URL : <strong>{{ $pi->item_url }}</strong></p>
							@if(isset($pi->pconf_path))
								<p>Path : <strong>{{ $pi->pconf_path }}</strong></p>
							@endif
                                                        @if(isset($pi->pconf_reference_id))
								<p>Reference : <strong>{{ chr($pi->pconf_reference_id+64) }}</strong></p>
							@endif
							@if(isset($pi->pconf_template))
								<p>Template File :</p>
								<br />
								<a href="{{ url('/download/'.Crypt::encrypt($pi->pconf_template).'/s') }}" class="btn btn-primary btn-icon btn-icon-standalone">
									<i class="fa-download"></i>
				    				<span>Download Template </span>
								</a>
							@endif
						</div>
					</div>
			@endforeach
		@endif

			</div>

<script>
$("document").ready(function(){
    $(".item_edit").on('click',function(){
          $( ".edit-div").load('/items/'+$(this).attr('id')+'/edit');
    });
});

</script>
