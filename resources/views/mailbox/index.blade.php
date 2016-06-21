@extends('../app')
@section('content')

			<section class="mailbox-env">
			
				<div class="row">
			
					<!-- Inbox emails -->
					<div class="col-sm-9 mailbox-right">
			
						<div class="mail-env">
			
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									var $state = $(".mail-table thead input[type='checkbox'], .mail-table tfoot input[type='checkbox']"),
										$chcks = $(".mail-table tbody input[type='checkbox']");
			
									// Script to select all checkboxes
									$state.on('change', function(ev)
									{
										if($state.is(':checked'))
										{
											$chcks.prop('checked', true).trigger('change');
										}
										else
										{
											$chcks.prop('checked', false).trigger('change');
										}
									});
			
									// Row Highlighting
									$chcks.each(function(i, el)
									{
										var $tr = $(el).closest('tr');
			
										$(this).on('change', function(ev)
										{
											$tr[$(this).is(':checked') ? 'addClass' : 'removeClass']('highlighted');
										});
									});
			
									// Stars
									$(".mail-table .star").on('click', function(ev)
									{
										ev.preventDefault();
			
										if( ! $(this).hasClass('starred'))
										{
											$(this).addClass('starred').find('i').attr('class', 'fa-star');
										}
										else
										{
											$(this).removeClass('starred').find('i').attr('class', 'fa-star-o');
										}
									});
								});
							</script>

			       @if($mail_count > 0)
							<!-- mail table -->
							<table class="table mail-table">
			
								<!-- mail table header -->
								<thead>
									<tr>
										<th class="col-cb">
											<input type="checkbox" class="cbr" />
										</th>
										<th colspan="4" class="col-header-options">
			
											<div class="mail-select-options">Select all</div>
			
											<div class="mail-pagination">
												Showing <strong>
												{{ (isset($_GET['page'])) ? $_GET['page']*$pagination_value : 1 }} 
												to @if(!isset($_GET['page']))
													{{ (1*$pagination_value > $mail_count) ? $mail_count : $pagination_value  }}
												   @else
												   	{{ ($_GET['page']*$pagination_value > $mail_count) ? $mail_count : $pagination_value*$_GET['page'] }}
												   @endif	
												</strong> of <strong>{{ $mail_count }}</strong> emails
												{!! $mailbox->render(); !!} 

											</div>
										</th>
									</tr>
								</thead>
			
								<!-- mail table footer -->
								<tfoot>
									<tr>
										<th class="col-cb">
											<input type="checkbox" class="cbr" />
										</th>
										<th colspan="4" class="col-header-options">
			
											<div class="mail-select-options">Select all</div>
			
											<div class="mail-pagination">
												Showing <strong>
												{{ (isset($_GET['page'])) ? $_GET['page']*$pagination_value : 1 }} 
												to @if(!isset($_GET['page']))
													{{ (1*$pagination_value > $mail_count) ? $mail_count : $pagination_value  }}
												   @else
												   	{{ ($_GET['page']*$pagination_value > $mail_count) ? $mail_count : $pagination_value*$_GET['page'] }}
												   @endif	
												</strong> of <strong>{{ $mail_count }}</strong> emails
												{!! $mailbox->render(); !!}
											</div>
										</th>
									</tr>
								</tfoot>
			
								<!-- email list -->
								<tbody>
								
			                       @foreach($mailbox as $mbox)
									<tr @if($mbox->em_read_status == 0 && strcmp($folder,"inbox") == 0) class="unread" @endif >
										<td class="col-cb">
											<div class="checkbox checkbox-replace">
												<input type="checkbox" class="cbr" />
											</div>
										</td>
										<td class="col-name">
											@if(strcmp($folder,"inbox") == 0)
												<a href="{{ url('mailbox/'.$mbox->em_id.'/message/'.$folder) }}" class="col-name">{{ $mbox->em_subject }}</a>
											@else
											    <a href="{{ url('mailbox/'.$mbox->em_id.'/message/'.$folder) }}" class="col-name">{{ $mbox->em_subject }}</a>
											@endif	
										</td>
										
										<td class="col-subject" style="visibility:hidden">
											@if(strcmp($folder,"inbox") == 0)
												<a href="{{ url('mailbox/'.$mbox->em_id.'/message/'.$folder) }}">{{ str_limit(strip_tags($mbox->em_message), $limit = 180, $end = '...') }}</a>
											@else
											    <a href="{{ url('mailbox/'.$mbox->em_id.'/message/'.$folder) }}">{{ str_limit(strip_tags($mbox->em_message), $limit = 180, $end = '...') }}</a>
											@endif
										</td>
										
										<td class="col-options hidden-sm hidden-xs">@if($mbox->em_attachment) <a href=""><i class="linecons-attach"></i></a>  @endif</td>
										<td class="col-time">{{ $mbox->em_dt }}</td>
									</tr>								
									@endforeach
								</tbody>
			
							</table>
                  @else
                      <p align="center">{{ $dictionary['mbox_no_emails'] }}</p>
                  @endif
						</div>
			
					</div>
			
			  
			
					<!-- Mailbox Sidebar -->
					@include("mailbox.mail_sidebar")
					
				</div>
			
			</section>


@endsection

