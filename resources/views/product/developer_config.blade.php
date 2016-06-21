
<style>
.btn-dconf { width: 40px; margin-bottom: 0px;}
.tbl-border { border:none !important; }
</style>

<div class="tab-pane ">
	<div class=""><!-- Add class "collapsed" to minimize the panel -->

		<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Add Developer Configurations</h3>
								</div>
								<div class="panel-body">

									{!! Form::open(['url' => 'developer-configurations','class'=>'form-inline']) !!}
													{!! Form::hidden('dconf_product_id',$product->id) !!}

										<div class="form-group">
											<input name="dconf_name" class="form-control" size="25" placeholder="Name" type="text">
										</div>

										<div class="form-group">
											<input name="dconf_value" class="form-control" size="25" placeholder="Value" type="text">
										</div>

										<div class="form-group">
											<button class="btn btn-success btn-single"><i class="fa fa-plus"></i></button>
										</div>

									{!! Form::close() !!}

								</div>
							</div>




	<!-- Responsive Table -->
							<div class="table-responsive tbl-border" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

	@if(count($prodConfigs['devConfig']) > 0)

	<form action="{{ url('/developer-configurations/bulk-update') }}" method="POST">
		  {!! Form::token(); !!}
					{!! Form::hidden('dconf_product_id',$product->id) !!}

								<table class="table table-bordered table-striped table-condensed table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Value</th>
											<th>Status</th>
											<th colspan="2">Actions</th>
										</tr>
									</thead>
									<tbody>
									@foreach($prodConfigs['devConfig'] as $dconf)
										<tr>
											<td><input name="dconf_id[]" class="dconf-{{ $dconf->dconf_id }} form-control" type="hidden" value="{{ $dconf->dconf_id }}" />{{ $dconf->dconf_id }}</td>
											<td><input name="dconf_name[]" class="dconf-{{ $dconf->dconf_id }} form-control" readonly type="text" value="{{ $dconf->dconf_name }}" /></td>
											<td><input name="dconf_value[]" class="dconf-{{ $dconf->dconf_id }} form-control" readonly type="text" value="{{ $dconf->dconf_value }}" /></td>
											<td><select name="dconf_status[]" class="dconf-{{ $dconf->dconf_id }} form-control" readonly>
												<option @if($dconf->dconf_status == 0) selected @endif value="0">InActive</option>
												<option @if($dconf->dconf_status == 1) selected @endif value="1">Active</option>
													</select>
											</td>
											<td><a id="dconf-{{ $dconf->dconf_id }}" class="btn btn-blue form-control btn-dconf edit-fields"><i class="fa fa-edit"></i></a>
											<a href="{{ url('developer-configurations/'.$dconf->dconf_id.'/delete-dev-config') }}" onclick="return confirm('{{ $dictionary['delete_confirm_alert'] }}')" class="btn btn-red form-control btn-dconf">
												<i class="fa fa-trash"></i>
											</a>
											</td>
										</tr>
										@endforeach
										<tr><td colspan="4"></td><td> <input type="submit" value="Save" class="btn btn-info form-control" /> </td><tr>
									</tbody>
								</table>


				</form>
		@endif

							</div>

    </div>
</div>
<script>
$("document").ready(function(){
    $(".edit-fields").on('click',function(){
			 $("."+$(this).attr('id')).removeAttr( "readonly");
		});
});
</script>
