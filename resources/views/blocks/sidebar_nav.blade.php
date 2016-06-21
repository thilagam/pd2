	
		<!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
		<!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
		<!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
		<div class="sidebar-menu toggle-others fixed">
		
			<div class="sidebar-menu-inner">
				
				<ul id="main-menu" class="main-menu">

				<li class="search-form"><!-- You can add "always-visible" to show make the search input visible -->
			
					
					
				</li>
				@foreach($products_per_user as $key => $value)
				 @if(isset($value['products']))  
				<li class="has-sub @if(!empty(Request::segment(3)) && in_array( Request::segment(3),explode(',',$value['all'])) === true) expanded  @endif">
				    <a href="{{ url('client')}}/{{$key}}" alt="client link">
					<i class="linecons-cog"></i>
					<span class="title">{{ $value['name'] }}</span>
				    </a>	
				    
				    <ul @if(!empty(Request::segment(3)) && in_array( Request::segment(3),explode(',',$value['all'])) === true) style="display:block;"  @endif>
               
				    @foreach($value['products'] as $key2 => $value2)
				    	@if(count($value['products'])>1)
				    	<li class="has-sub @if($key2 == Request::segment(3)) expanded  @endif">
							<a href="{{ url('product')}}/{{$key2}}" alt="product link">
								<span class="title">{{ $value2['name'] }}</span>
							</a>
							<ul @if(!empty(Request::segment(3)) && $key2 == Request::segment(3)) style="display:block;"  @endif>
							   <li> 
							   		<a href="{{ url('product')}}/{{$key2}}" alt="item link">	
							    		<span class="title">{{ $dictionary['prod_home']}}</span>
							    	</a>
							   </li>
						@endif
							@if(count($value['products'])==1)
								<li>
							   		<a href="{{ url('product')}}/{{$key2}}" alt="item link">	
							    		<span class="title">{{ $dictionary['prod_home']}}</span>
							    	</a>
							   	</li>
							@endif
							@if(isset($value2['items']))
							@foreach($value2['items'] as $key3 => $value3)
							    @if($permit->{"module_sidebar_".$value3['name']} )
								<li @if(!empty(Request::segment(3)) && in_array( Request::segment(2),explode('_',$value3['name'])) === true) class="active" @endif>  
							    	<a href="{{ url($value3['url'])}}" alt="item link">	
							    		<span class="title">@if(isset($dictionary[$value3['name']])) {{ $dictionary[$value3['name']] }} @else {{ $value3['name'] }} @endif</span>
							    	</a>	
							    </li>
							    @endif	
							@endforeach
							@endif
						@if(count($value['products'])>1)
							</ul>
						</li>
						@endif
				    @endforeach		
				 	</ul>
				 
				</li> @endif  	
				@endforeach	 
				</ul>
				
			</div>
		
		</div>

