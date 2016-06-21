@extends('../app')
@section('content')

<style>
.alert-danger { background:#CC3F44 !important; }
</style>

<div class="row">
@if($permit->module_product_upload_reference)


	<div class="col-sm-12">

	      @include('blocks.error_block')
		<div class="panel panel-default" style="background: #E3E3E3 none repeat scroll 0% 0%;">
			<div class="panel-heading">
				<h3 class="panel-title">{{ $dictionary['upload_ref_file_validate'] }}</h3>

			</div>
			<div class="panel-body">

<!-- tabs start -->

<div class="row">

           	<!-- Collapsed panel -->
						<div class="panel panel-default collapsed"><!-- Add class "collapsed" to minimize the panel -->
							<div class="panel-heading">
								<h3 class="panel-title">Errors / Warning</h3>

								<div class="panel-options">

									<a href="#" data-toggle="panel">
										<span class="collapse-icon">&ndash;</span>
										<span class="expand-icon">+</span>
									</a>
								</div>
							</div>

							<div class="panel-body">
										<h6>Comparision Status</h6>

										<div class="table-responsive" data-pattern="priority-columns" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

											<table  cellspacing="0" class="table table-bordered table-striped table-condensed table-hover">
												<thead>
													<tr><th>Compare</th><th>Developer Config</th><th>Current File</th></tr>
												</thead>
												<tbody>
													<tr class="{{ $comparedArray['fileSize']['status'] }}"><th>Size(Kb)</th><td>{{ $comparedArray['fileSize']['devconfig'] }}</td><td>{{ $comparedArray['fileSize']['currentfile'] }}</td></tr>
													<tr class="{{ $comparedArray['fileSize']['status'] }}"><th>Sheet(Count)</th><td>{{ $comparedArray['sheetCount']['devconfig'] }}</td><td>{{ $comparedArray['sheetCount']['currentfile'] }}</td></tr>
													<tr class="{{$comparedArray['sheetDimensionStatus']}}"><th>Sheet(Dimension)</th>
														@foreach($comparedArray['sheetDimension'] as $cmpar)
														  <td>
																@foreach($cmpar as $ca)
																		{!! $ca !!}
																@endforeach
															</td>
														@endforeach
													</tr>
													<tr><th>Others</th>
														@foreach($comparedArray['sheetHeader'] as $cmpar)
															<td>
																@foreach($cmpar as $ca)
																		{!! $ca !!}
																@endforeach
															</td>
														@endforeach
													</tr>
												</tbody>
											</table>
										</div>


							</div>
						</div>


				<div class="col-md-12" style="padding:0;">

					<div class="panel-heading">
						<h3 class="panel-title">View of Upload & Dev Config File</h3>
					</div>

					<br />

					<ul class="nav nav-tabs">
						@foreach($validate_array['sheetData'] as $key=>$sheetData)
						<li class="@if($key == 0) active @endif">
							<a href="#tab-sheet-{{$key}}" data-toggle="tab">
								<span class="visible-xs"><i class="fa-home"></i></span>
								<span class="hidden-xs">{{ $validate_array['sheetTitle'][$key] }}</span>
							</a>
						</li>
						@endforeach
					</ul>

					<div class="tab-content">
						@foreach($validate_array['sheetData'] as $key=>$sheetData)
						<div class="tab-pane @if($key == 0) active @endif" id="tab-sheet-{{$key}}">
							<div>
								<!-- table -->
								<div class="table-responsive" data-pattern="priority-columns" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

									<table  cellspacing="0" class="table table-bordered table-striped table-condensed table-hover">
										<tbody>
												  @foreach($validate_array['sheetData'][$key] as $ky=>$rowData)
														 <tr>
															   @foreach($rowData as $k=>$columnData)
																     <td>{{ $columnData }}</td>
																 @endforeach
													   </tr>
													@endforeach
										</tbody>
									</table>
																		<hr />
									@if(sizeof($devConfigArray['sheetData']) > $key)

									<table  cellspacing="0" class="table table-bordered table-striped table-condensed table-hover">
										<tbody>

													@foreach($devConfigArray['sheetData'][$key] as $ky=>$rowData)
														<tr>
																@foreach($rowData as $k=>$columnData)
																			<td>{{ $columnData }}</td>
																@endforeach
														</tr>
													@endforeach

										</tbody>
									</table>
									@endif
								</div>

								<!-- table -->
							</div>
						</div>
						@endforeach
					</div>


				</div>
			</div>

<!-- close tabs start -->
				<a class="btn btn-success pull-right" href="{{ url('/refupload/'.$upload->upload_id.'/after') }}">Verify</a>

		</div>
	</div>
	</div>


@endif

</div>

@endsection
