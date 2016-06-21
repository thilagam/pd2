@extends('../app')

@section('content')
<div class="panel panel-default" style="background: #E3E3E3 none repeat scroll 0% 0%;">

				
				<div class="panel-body">
		
			<section class="gallery-env">
			
				<div class="row">
			
					<!-- Gallery Album Optipns and Images -->
					<div class="col-sm-9 gallery-right">
			
						<!-- Album Header -->
						<div class="album-header">
							<h2>{{ $folder_show }} </h2>		
							
						</div>
			
						<!-- Sorting Information -->
						<div class="album-sorting-info">
							<div class="album-sorting-info-inner clearfix">
								<a href="#" class="btn btn-secondary btn-xs btn-single btn-icon btn-icon-standalone pull-right" data-action="sort">
									<i class="fa-save"></i>
									<span>Save Current Order</span>
								</a>
			
								<i class="fa-arrows-alt"></i>
								Drag images to sort them
							</div>
						</div>
			
						<!-- Album Images -->
						<div class="album-images row">
			
							<!-- Album Image -->

							@foreach($reference_listing as $key=>$rl)
							   <div class="col-md-3 col-sm-4 col-xs-6">	
							     <div class="album-image">	
									<a href="{{ url('product/ftp/'.Crypt::encrypt($product_id).'/images/?f='.Crypt::encrypt($folder_show).'&r='.Crypt::encrypt($rl)) }}" class="name" style="line-height:1.3;">
										<span>{{ $rl }}</span>
										<em>&nbsp;</em>
									</a>
									<a target="_new" href="{{ url('product/ftp/'.$product_id.'/picture/?f='.$folder_show.'&r='.$rl) }}">
										<i class="fa fa-external-link-square"></i>
									</a>
								 </div>
							   </div>	 	
			                @endforeach
				
						</div>
			
			
						<button class="btn btn-white btn-block" style="display:none">
							<i class="fa-bars"></i>
							Load More Images
						</button>
			
					</div>
			
					<!-- Gallery Sidebar -->
					<div class="col-sm-3 gallery-left">
			
						<div class="gallery-sidebar">

							<ul class="list-unstyled">
								<li class="active label-success">
									<a href="#">
										<i class="fa-folder-open-o"></i>
										<span>{{ $dictionary['all_ftp_folders'] }}<i class="fa-long-arrow-down pull-right"></i> </span>
									</a>
								</li>
								<div class="scrollable" data-max-height="400">
						@foreach($folder_listing as $fl)		
								<li class="active">
									<a href="?f={{ $fl }}">
										<i class="fa-folder"></i>
										<span> {{ $fl }} </span>
									</a>
								</li>	
						@endforeach	
						        </div>	
							</ul>
						  
						</div>
			
					</div>
			
				</div>
			
			</section>

 
 
					
					
				</div>
			</div>
@endsection
