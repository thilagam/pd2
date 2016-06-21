<div class="col-sm-3 mailbox-left">
			
						<div class="mailbox-sidebar">
			
							<a href="{{ route('mailbox.create') }}" class="btn btn-block btn-secondary btn-icon btn-icon-standalone btn-icon-standalone-right">
								<i class="linecons-mail"></i>
								<span>{{ $dictionary['mbox_compose'] }}</span>
							</a>
			
			
							<ul class="list-unstyled mailbox-list">
								<li @if(strcmp($folder,"inbox") == 0) class="active" @endif>
									<a href="{{ url('mailbox') }}">
										{{ $dictionary['mbox_inbox'] }}
										@if($unread_count > 0)<span class="badge badge-success pull-right">  {{ $unread_count }} </span>@endif
									</a>
								</li>
								<li @if(strcmp($folder,"sent") == 0) class="active" @endif>
									<a href="{{ route('mailbox.show','sent') }}">
										{{ $dictionary['mbox_sent'] }}
									</a>
								</li>
								<li @if(strcmp($folder,"draft") == 0) class="active" @endif>
									<a href="{{ route('mailbox.show','draft') }}">
										{{ $dictionary['mbox_drafts'] }}
									</a>
								</li>
								<li @if(strcmp($folder,"trash") == 0) class="active" @endif>
									<a href="{{ route('mailbox.show','trash') }}">
										{{ $dictionary['mbox_trash'] }}
									</a>
								</li>
							</ul>
			
							<div class="vspacer"></div>
			
						</div>
			
					</div>
