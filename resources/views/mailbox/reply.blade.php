@extends('../app')
@section('content')
     
      @include('blocks.error_block')
     {!! Form::model($message,['files'=>true, 'method' => 'PATCH','route'=>['mailbox.update',$message->em_id]]) !!}
     
     <input name="em_ticket_id" type="hidden" value="{{ $message->em_ticket_id }}" />
     
<style>
#s2id_autogen1 { height:45px; }
#s2id_s2example-2 { padding-left: 9%; }
</style>
                                <style type="text/css">
                                            .myFile {
                                              position: relative;
                                              overflow: hidden;
                                              float: left;
                                              clear: left;
                                            }
                                            .myFile input[type="file"] {
                                              display: block;
                                              position: absolute;
                                              top: 0;
                                              right: 0;
                                              opacity: 0;
                                              font-size: 100px;
                                              filter: alpha(opacity=0);
                                              cursor: pointer;
                                            }
                                </style>
<section class="mailbox-env">
				
				<div class="row">
									<script type="text/javascript">
										jQuery(document).ready(function($)
										{
											$("#s2example-2").select2({
												placeholder: '',
												allowClear: true
											}).on('select2-open', function()
											{
												// Adding Custom Scrollbar
												$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
											});
											
										});
									</script>										
					
					
					<!-- Compose Email Form -->
					<div class="col-sm-9 mailbox-right">
						
						<div class="mail-compose">
							
							<form method="post" role="form"  enctype="multipart/form-data">
							
								<!-- Header Title and Button Options -->
								<div class="mail-header">
									<div class="row">
										<div class="col-sm-6">							
											<h3>
												<i class="linecons-pencil"></i>
												{{ $dictionary['mbox_reply_mail'] }}
											</h3>
										</div>
										
										<div class="col-sm-3 col-xs-5">

										</div>
										
										<div class="col-sm-3 col-xs-8">					
											<button type="submit" class="btn btn-secondary btn-single btn-icon btn-icon-standalone btn-icon-standalone-right btn-block">
												<i class="linecons-mail"></i>
												<span>{{ $dictionary['mbox_send_button'] }}</span>
											</button>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									  <label for="to">{{ $dictionary['mbox_to'] }}:</label>
         									<select class="form-control" id="s2example-2" name="em_to[]" multiple >
													<option selected value="{{ $message->userfrom->id }}">{{ $message->userdetails->up_first_name." ".$message->userdetails->up_last_name." (".$message->userfrom->email.") " }}</option>
											</select>
								</div>
								
								<div class="form-group">
									<label for="subject">{{ $dictionary['mbox_subject'] }}:</label>
									<input value="Re: {{ $message->em_subject }}" type="text" class="form-control" id="subject" tabindex="1" name="em_subject" />
								</div>
								
								
								<div class="compose-message-editor">
									<textarea name="em_message" class="form-control wysihtml5" data-html="false" data-color="false" data-stylesheet-url="assets/css/other/wysihtml5-color.css" name="sample_wysiwyg" id="sample_wysiwyg"></textarea>
								</div>
							
								<div class="row">
									<div class="col-sm-3">
										<button type="submit" class="btn btn-secondary btn-block btn-icon btn-icon-standalone">
											<i class="linecons-mail"></i>
											<span>{{ $dictionary['mbox_send_button'] }}</span>
										</button>
									</div>
									
									<div class="col-sm-offset-6 col-sm-3">

<div class="">
<label class="myFile">
<div class="btn btn-white btn-single btn-block btn-icon btn-icon-standalone">
<i class="fa-plus"></i>
 <input type="file" name="files[]" class="btn btn-default" id="template" placeholder="{{ $dictionary['mbox_attach_file'] }}" multiple /> 
<!-- {!! Form::file('file[]','',['class'=>'', 'id'=>'template', 'placeholder'=>$dictionary['placeholder_upload'], 'multiple'=>true ]) !!} -->
<span>{{ $dictionary['mbox_attach_file'] }} </span>
</div>
</label>
</div>



									</div>
								</div>
								
							<!--/form-->
							
						</div>
						
						
					</div>
					
					
					
					
					
					
					<!-- Mailbox Sidebar -->
					@include("mailbox.mail_sidebar")
			
				</div>
				
			</section>

			
	 {!! Form::close() !!}		

	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/select2/select2-bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('/assets/js/multiselect/css/multi-select.css') }}">


	<!-- Imported scripts on this page -->
	<script src="{{ asset('/assets/js/select2/select2.min.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('/assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>
	<script src="{{ asset('/assets/js/tagsinput/bootstrap-tagsinput.min.js') }}"></script>
	<script src="{{ asset('/assets/js/typeahead.bundle.js') }}"></script>
	<script src="{{ asset('/assets/js/handlebars.min.js') }}"></script>
	<script src="{{ asset('/assets/js/multiselect/js/jquery.multi-select.js') }}"></script>


@stop
