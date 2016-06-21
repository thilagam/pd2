@extends('../app')
@section('content')

<div class="row">
	
@if($permit->module_product_upload_pdn)
	<div class="col-sm-12">

	      @include('blocks.error_block')
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{ $dictionary['upload_pdn_files'] }}</h3>
				
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
			<div class="panel-body">
		
				{!! Form::open(['url' => '/product/pdnupload/'.$prodConfigs['pdn']['pconf_product_id'],'method'=>'post','id'=>'productpdn','class'=>'form-horizontal','enctype'=>'multipart/form-data']) !!}	
			
				{!! Form::hidden('pconf_item_id', $prodConfigs['pdn']['pconf_item_id']) !!}

					<div class="form-group">
						{!! Form::label($dictionary['fprwd_upload'],$dictionary['fprwd_upload'],['class'=>'col-sm-2 control-label']) !!}
									       
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
				                      {{ $dictionary['fprwd_upload']}}<input type="file" name="file_pdn_1" multiple>
				                    </span>
				                </span>
				                <!-- <input type="text" class="form-control" readonly> -->
				                {!! Form::text('file_pdn',null,['class'=>'form-control','placeholder'=>'placeholder_upload','readonly']) !!}
									        
				            </div>
						</div>
						
					</div>
					<div class="clearfix"></div>
					<div class="form-group-separator"></div>
					<div class="form-group">
						<label class="col-sm-2 control-label">{{ $dictionary['fprwd_reference'] }}</label>
						
						<script type="text/javascript">
							jQuery(document).ready(function($)
							{
								$("#pdn_pdn").selectBoxIt({
									showFirstOption: false
								}).on('open', function()
								{
									// Adding Custom Scrollbar
									$(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
								});
							});
						</script>

						<div class="col-sm-5">
							
							{!! Form::select('pdn_pdn',
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
					<div class="clearfix"></div>
					<div class="form-group-separator"> </div>
					<div class="form-group">
						<div class="col-sm-12">
							 <button style="margin-left:2%" type="submit" class="btn btn-info btn-single pull-right"> {{ $dictionary['fprwd_upload_btn'] }}</button> 
							
							<button type="button" class="btn btn-warning btn-single pull-right"> {{ $dictionary['fprwd_reset_btn'] }}</button> 	
						</div>
					</div>
					<div class="clearfix"></div>
						
					
				    {!! Form::close() !!}
			</div>
		</div>
	</div>
@endif


@if($permit->module_product_upload_validate_pdn)
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{ $dictionary['validate_pdn_files'] }}</h3>
				
			</div>
			<div class="panel-body">

<script type="text/javascript">
jQuery(document).ready(function($)
{
        $("#example-2").dataTable({
            "oLanguage": {
                            "sSearch": "{{ $dictionary['dtable_search'] }}",
                            "sLengthMenu": "{{ $dictionary['dtable_length_menu_show'] }}"+'&nbsp;<select class="form-control input-sm" aria-controls="example-2" name="example-2_length"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>&nbsp;'+"{{ $dictionary['dtable_length_menu_entries'] }}"
                         }

        });
        
         // Replace checkboxes when they appear
});
</script>
				
				<table class="table table-bordered table-striped" id="example-2">
					<thead>
						<tr class="bg-info">
							<th>{{ $dictionary['fprwd_date'] }}</th>
							<th>{{ $dictionary['fprwd_uploader'] }}</th>
							<th style="display:none">deadline</th>
							<th>{{ $dictionary['fprwd_action'] }}</th>
						</tr>
					</thead>
					@foreach($prodConfigs['pdn_uploads_verify'] as $ruv)

					<tbody class="middle-align">
						  <tr>
						  	<td>{{ $ruv->dt }}</td>
						  	<td>{{ $ruv->up_first_name }} {{ $ruv->up_last_name }} - [ {{ $ruv->upload_by }} ]</td>
						  	<td style="display:none">8 Hrs</td>
						  	<td><a href="{{ url('/download/'.Crypt::encrypt($ruv->upload_url).'/s') }}" class="btn btn-info btn-sm btn-icon icon-left">
									Download
								</a>

								<a id="{{ $ruv->upload_id }}" href="javascript:void(0)" onclick="jQuery('#modal-1').modal('show', {backdrop: 'fade'});assignUrl(this.id);" class="btn btn-danger btn-sm btn-icon icon-left reject-btn">
									Reject
								</a>
								
								<a href="{{ url('/product/approveupload/'.$ruv->upload_id) }}" class="btn btn-success btn-sm btn-icon icon-left">
									Approve
								</a>

								</td>

						  </tr>
					</tbody>

				@endforeach	
				</table>
			</div>
		</div>	
	</div>
@endif

	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{ $dictionary['old_pdn_files'] }}</h3>
			</div>
			<div class="panel-body">
<script type="text/javascript">
jQuery(document).ready(function($)
{
        $("#example-3").dataTable({
            "oLanguage": {
                            "sSearch": "{{ $dictionary['dtable_search'] }}",
                            "sLengthMenu": "{{ $dictionary['dtable_length_menu_show'] }}"+'&nbsp;<select class="form-control input-sm" aria-controls="example-2" name="example-2_length"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>&nbsp;'+"{{ $dictionary['dtable_length_menu_entries'] }}"
                         }

        });
        
         // Replace checkboxes when they appear
});
</script>
				
				<table class="table table-bordered table-striped" id="example-3">
					<thead>
						<tr class="bg-info">
							<th>{{ $dictionary['fprwd_date'] }}</th>
							<th>{{ $dictionary['fprwd_uploader'] }}</th>
							<th>{{ $dictionary['fprwd_original_name'] }}</th>
							<th>{{ $dictionary['fprwd_modified_name'] }}</th>
							<th>{{ $dictionary['fprwd_reference'] }}</th>
							<th>{{ $dictionary['fprwd_status'] }}</th>
						</tr>
					</thead>
					
					<tbody class="middle-align">
						@foreach($prodConfigs['pdn_uploads_verifed'] as $ruv)
						  <tr>
							<td>{{ $ruv->dt }}</td>
						  	<td>{{ $ruv->up_first_name }} {{ $ruv->up_last_name }} - [ {{ $ruv->upload_by }} ]</td>
						  	<td><a href="">{{ $ruv->upload_original_name }}</a></td>
						  	<td><a href="">{{ $ruv->upload_name }}</a> 	<a class="pull-right" href="{{ url('/download/'.Crypt::encrypt($ruv->upload_url).'/s') }}"><i class="fa-download"></i></a>
						  	</td>
						  	<td>{{ chr(64+$ruv->upload_reference_column) }}</td>
						  	<td>@if($ruv->upload_verification_status == 2) Rejected  @endif </td>
						  </tr>
					    @endforeach	
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
		
	<!-- Modal 1 (Basic)-->
	<div class="modal fade" id="modal-1">
		<div class="modal-dialog">
			<div class="modal-content" style="top:86px;">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Please Specify the Resaon For Rejection</h4>
				</div>

{!! Form::open(['url' => '','method'=>'post','id'=>'productpdnverify','name'=>'productpdnverify','class'=>'form-horizontal','enctype'=>'multipart/form-data']) !!}

				<div class="modal-body">
					<textarea name="upload_verification_msg" class="form-control" placeholder="Type Your Reason Here!"> </textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info">Save changes</button>
				</div>
	
{!! Form::close() !!}	

			</div>
		</div>
	</div>


<script src="{{ asset('/assets/js/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>


<script>
function assignUrl(url_value){
	document.productpdnverify.action = "/product/pdnuploadverify/"+url_value;
}
</script>

@endsection
