@extends('../app')
@section('content')
<section class="mailbox-env">
			
				<div class="row">
			
					<!-- Email Single -->
					<div class="col-sm-9 mailbox-right">
			
						<div class="mail-single">
			
							<!-- Email Title and Button Options -->
							<div class="mail-single-header">
								<h2>
									{{ $mailbox['em_subject'] }}

			
									<a href="{{ url('mailbox') }}" class="go-back">
										<i class="fa-angle-left"></i>
										{{ $dictionary['mbox_go_back'] }}
									</a>
								</h2>
			
								<div class="mail-single-header-options"> 
								 @if(strcmp($bool,"inbox") == 0 && strcmp($mailbox->from_email,"noreply@edit-place.com") != 0)
									<a href="{{ url('mailbox/'.$mailbox->em_id.'/reply') }}" class="btn btn-gray btn-icon">
										<i class="fa-reply-all"></i>
									</a>
								@endif	
								@if(strcmp($bool,"draft") != 0)
									<a href="{{ url('mailbox/'.$mailbox->em_id.'/save') }}" class="btn btn-gray btn-icon">
										<i class="fa-save"></i>
									</a>
								@endif	
								@if(strcmp($bool,"trash") != 0)
									<a href="{{ url('mailbox/'.$mailbox->em_id.'/delete') }}" class="btn btn-gray btn-icon">
										<i class="fa-trash"></i>
									</a>
								@endif	
								</div>
							</div>
			
							<!-- Email Info From/Reply -->
							<div class="mail-single-info">
			
								<div class="mail-single-info-user dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										
										<img src="@if($mailbox->from_profile_image!='') {{ asset('uploads/'.$mailbox->from_profile_image)}} @else {{ asset('assets/images/user-1.png') }} @endif" class="img-circle" width="38" alt="user-pic" />
										<span>
											@if(Auth::id() == $mailbox->em_from)
												You
											@else
											   {{ $mailbox->from_first_name }} ({{ $mailbox->from_email }}) 
											@endif						
										</span>
									          to
										<span>
											@if(Auth::id() == $mailbox->em_to)
												me
											@else
											   {{ $mailbox->to_first_name }} ({{ $mailbox->to_email }}) 
											@endif
										</span>
										
										
										<em class="time">{{ $mailbox->date_time }}</em>
									</a>
											
								</div>
			
								<div class="mail-single-info-options">
									@if($mailbox->em_attachment)
									<a href="#">
										<i class="linecons-attach"></i>
									</a>
									@endif
								</div>
			
							</div>
							<!-- Email Body -->
							<div class="mail-single-body">
								  {!! $mailbox->em_message !!}
							</div>
			
					@if($mailbox->em_attachment)
			
							<!-- Email Attachments -->
							<div class="mail-single-attachments">
								<h3>
									<i class="linecons-attach"></i>
									Attachments
								</h3>
			
								<ul class="list-unstyled list-inline">
								   @foreach($email_attachment as $eatt)
								   <li>
										<a href="/download/{{ Crypt::encrypt($eatt->attfiles_path) }}/s">
											@if($eatt->attfiles_type == "xls" || $eatt->attfiles_type == "xlsx")
												<i class="fa fa-file-excel-o" style="font-size:45px;"></i>
											@elseif($eatt->attfiles_type == "pdf")
												<i class="fa fa-file-pdf-o" style="font-size:45px;"></i>
											@elseif($eatt->attfiles_type == "zip" || $eatt->attfiles_type == "rar")
												<i class="fa fa-file-zip-o" style="font-size:45px;"></i>
											@elseif($eatt->attfiles_type == "doc" || $eatt->attfiles_type == "docx")
												<i class="fa fa-file-word-o" style="font-size:45px;"></i>
											@elseif($eatt->attfiles_type == "jpg" || $eatt->attfiles_type == "jpeg" || $eatt->attfiles_type == "png" || $eatt->attfiles_type == "gif" || $eatt->attfiles_type == "bmp")
												<i class="fa fa-file-image-o" style="font-size:45px;"></i>
											@else
												<i class="fa fa-file-text-o" style="font-size:45px;"></i>
											@endif
																							
										</a>
			
										<a href="/download/{{ Crypt::encrypt($eatt->attfiles_path) }}/s" class="name">
											{{ $eatt->attfiles_name }}
										</a>
			
										<div class="links">
											<a href="/download/{{ Crypt::encrypt($eatt->attfiles_path) }}/s">Download</a>
										</div>
									</li>
									@endforeach

								</ul>
							</div>
							
						@endif
						
					<!-- Old Conversation -->	
						@if(isset($oldmailbox))
						  @foreach($oldmailbox as $omb)	
							<div class="mail-single">
								<div class="mail-single-body">
										<h4><em class="time">{{ $omb->em_dt }}</em></h4>
										{!! str_replace("ET-MESSAGE",$omb->em_message,$mailbox->etempplus_template_code) !!} 
								</div>
							</div>
							
						  @endforeach	
						@endif	
	
						</div>
			
			
					</div>
			
					<!-- Mailbox Sidebar -->
					@include("mailbox.mail_sidebar")
			
				</div>
			
			</section>
@stop
