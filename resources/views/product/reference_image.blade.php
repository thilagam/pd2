@extends('../app')

@section('content')

<div class="panel panel-default" style="background: #E3E3E3 none repeat scroll 0% 0%;">

				
				<div class="panel-body">
					
<script type="text/javascript">
			// Sample Javascript code for this page
			jQuery(document).ready(function($)
			{
				// Sample Select all images
				$("#select-all").on('change', function(ev)
				{
					var is_checked = $(this).is(':checked');
			
					$(".album-image input[type='checkbox']").prop('checked', is_checked).trigger('change');
				});
			
				// Edit Modal
				$('.gallery-env a[data-action="edit"]').on('click', function(ev)
				{
					ev.preventDefault();
                    $("#full-view-image").attr("src",($(this).children().attr('src')));
					$("#gallery-image-modal").modal('show');
				});
			
				// Delete Modal
				$('.gallery-env a[data-action="trash"]').on('click', function(ev)
				{
					ev.preventDefault();
					$("#gallery-image-delete-modal").modal('show');
				});
			
			
				// Sortable
				$('.gallery-env a[data-action="sort"]').on('click', function(ev)
				{
					ev.preventDefault();
			
					var is_sortable = $(".album-images").sortable('instance');
			
					if( ! is_sortable)
					{
						$(".gallery-env .album-images").sortable({
							items: '> div',
							containment: 'parent'
						});
			
						$(".album-sorting-info").stop().slideDown(300);
					}
					else
					{
						$(".album-images").sortable('destroy');
						$(".album-sorting-info").stop().slideUp(300);
					}
				});
			});
			</script>
			
			<section class="gallery-env">
			
				<div class="row">
			
					<!-- Gallery Album Optipns and Images -->
					<div class="@if(Auth::check()) col-sm-9 @else col-sm-12 @endif gallery-right">
			
						<!-- Album Header -->
						<div class="album-header">
							<h2>Reference Id :- {{ $images_show }}</h2>
			
							<ul class="album-options list-unstyled list-inline">
								<li>
									
								</li>
								<li>
									
								</li>
							</ul>
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
									<a href="#" class="thumb" data-action="edit">
										<img id="{{ url($rl['ref_path']) }}" style="height:160px;width:190px;" src="{{ url($rl['ref_path']) }}" class="img-responsive">
									</a>
			
									<a href="#" class="name">
										<span>{{ $rl['ref_id'] }}</span>
										<em></em>
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
			

			@if(Auth::check())
					<!-- Gallery Sidebar -->
					<div class="col-sm-3 gallery-left">
			
						<div class="gallery-sidebar">
			
							<a href="{{ url('/product/ftp/'.$product_id) }}" class="btn btn-secondary">
								<i class="fa-folder"></i>
								<span>{{ $dictionary['all_ftp_folders'] }}</span>
							</a>
			
							<ul class="list-unstyled">
								<li class="active">
									<a href="#">
										<i class="fa fa-files-o"></i>
										<span>SOURCE  <span class="badge badge-green" style="float: right;">&nbsp;</span></span>
									</a>
								</li>
	                            <li class="active">
									<a href="#">
										<i class="fa fa-files-o"></i>
										<span>PDN  <span class="badge badge-red" style="float: right;">&nbsp;</span></span>
									</a>
								</li>
								<li class="active">
									<a href="#">
										<i class="fa fa-files-o"></i>
										<span>WRITER  <span class="badge badge-green" style="float: right;">&nbsp;</span></span>
									</a>
								</li>
								<li class="active">
									<a href="#">
										<i class="fa fa-files-o"></i>
										<span>DELIVERY  <span class="badge badge-red" style="float: right;">&nbsp;</span></span>
									</a>
								</li>
							</ul>
			
						</div>
			
					</div>
			@endif
			
				</div>
			
			</section>

 
            <div class="panel panel-default" style="display:none">
				
				<div class="panel-body">
					
									
					<table class="table table-bordered table-striped" id="example-2">
						<thead>
							<tr>
								<th class="no-sorting">
									Sl no
								</th>
								<th>Sku</th>
								<th>Sku parent</th>
								<th>Header1</th>
								<th>Header2</th>
								<th>Date/Time</th>
							</tr>
						</thead>
						
						<tbody class="middle-align">
														<tr>
								<td>1</td>
								<td>ZMU091</td>
								<td>GM_0091</td>
								<td>Data1 1</td>
								<td>Date2 1</td>
								<td>Sept 1 2015 </td>
								</tr>

								
						</tbody>
					</table>
					
				</div>
			</div>
 
 
					
					
				</div>
			</div>


	<!-- Gallery Modal Image -->
	<div class="modal fade" id="gallery-image-modal" style="margin-top: 5%;">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-gallery-image">
					<img id="full-view-image" src="assets/images/album-image-full.jpg" class="img-responsive" />
				</div>
				
				<div class="modal-body">
					
					<div class="row">
						<div class="col-md-12">
							
							<div class="form-group" style="display:none">
								<label for="field-1" class="control-label">Title</label>
								
								<input type="text" class="form-control" id="field-1" placeholder="Image Reference ID">
							</div>	
							
						</div>
					</div>
					
									
				</div>
				
				<div class="modal-footer modal-gallery-top-controls">
					<button type="button" class="btn btn-xs btn-white" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>	

<script type="text/javascript">

</script>

@endsection