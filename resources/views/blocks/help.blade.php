
<div id="chat" class="fixed"><!-- start: Chat Section -->
	
	<div class="chat-inner">
	
		
		<h2 class="chat-header">
			<a  href="#" class="chat-close" data-toggle="chat">
				<i class="fa-plus-circle rotate-45deg"></i>
			</a>
			
			{{ $dictionary['help_heading'] }}
			<span class="badge badge-success is-hidden">0</span>
		</h2>
		
		<script type="text/javascript">
		// Here is just a sample how to open chat conversation box
		jQuery(document).ready(function($)
		{
			/*var $chat_conversation = $(".chat-conversation");
			
			$(".chat-group a").on('click', function(ev)
			{
				ev.preventDefault();
				
				$chat_conversation.toggleClass('is-open');
				
				$(".chat-conversation textarea").trigger('autosize.resize').focus();
			});
			
			$(".conversation-close").on('click', function(ev)
			{
				ev.preventDefault();
				$chat_conversation.removeClass('is-open');
			}); */
		});
		</script>
		
		<!-- Product Specification  -->
		@if(!empty($rsb_specification['product']))
		
		<div class="chat-group">
			
			<div class="panel panel-default">
				<div class="panel-heading">
					{{ $dictionary['help_product_usage'] }}

					@if($permit->crud_product_specifications_direct_link)
					<a target="_new" class="pull-right" href="{{ url('/product-specifications/'.$rsb_specification['product']['specprod_id'].'/edit/') }}"><i class="fa-edit"></i></a>
					@endif

				</div>
				<div class="panel-body help-line-height">
					<p>{!! $rsb_specification['product']['specprod_usage'] !!}</p>
				</div>
			</div>
			
		</div>
		@if($rsb_specification['product']['specprod_attachment_id'] > 0)
		<div class="chat-group">
			<div class="panel panel-default">
				<div class="panel-heading">
					{{ $dictionary['help_product_files'] }}
				</div>
				<div class="panel-body">
					@foreach($rsb_specification['product']['attachments'] as $att)
					<span>
					<a href="/download/{{ Crypt::encrypt($att->attfiles_path) }}/s" class="btn btn-primary btn-icon btn-icon-standalone">
						<i class="fa-download"></i>
					    <span> {{ $att->attfiles_name }}</span>
					</a>
					</span>
					@endforeach	
				</div>
			</div>
		</div>
		@endif
		
		<div class="chat-group">
			
			<div class="panel panel-default">
				<div class="panel-heading">
					{{ $dictionary['help_product_description'] }} 
				</div>
				<div class="panel-body help-line-height">
					<p>{!! $rsb_specification['product']['specprod_description'] !!}</p>
				</div>
			</div>
			
		</div>
		<div class="chat-group" style="padding-bottom:20px">
			
			<div class="panel panel-default">
				<div class="panel-heading">
					{{ $dictionary['help_product_technical_info'] }}
				</div>
				<div class="panel-body help-line-height">
					<p>{!! $rsb_specification['product']['specprod_technical_info'] !!}</p>
					<br />
					<br />
				</div>
			</div>
			
		</div>
		@endif
		<!-- Close Product Specification -->


		<!-- General Specification -->
		@if(!empty($rsb_specification['general']))
		
		<div class="chat-group">
			
			<div class="panel panel-default help-line-height">
				<div class="panel-heading">
					{{{ $dictionary['help_general_description'] }}}

					@if($permit->crud_general_specifications_direct_link)
					<a target="_new" class="pull-right" href="{{ url('/general-specifications/'.$rsb_specification['general']['specgen_id'].'/edit/') }}"><i class="fa-edit"></i></a>
					@endif

				</div>
				<div class="panel-body">
					<p>{!! $rsb_specification['general']['specgen_description'] !!}</p>
				</div>
			</div>
			
		</div>
		@endif 
		<!-- Close General Specification -->
	
	</div>
</div>
<!-- end: Chat Section -->