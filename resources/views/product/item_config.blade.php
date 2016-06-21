
<style>
.btn-iconf { width: 40px; margin-bottom: 0px;}
.tbl-border { border:none !important; }
</style>

<div class="tab-pane ">
	<div class=""><!-- Add class "collapsed" to minimize the panel -->

		<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Add Item Configurations</h3>
								</div>
								<div class="panel-body">

									{!! Form::open(['url' => 'item-configurations','class'=>'form-inline']) !!}
													{!! Form::hidden('iconf_product_id',$product->id) !!}

										<div class="form-group">
											<input name="iconf_name" class="form-control" size="25" placeholder="Name" type="text">
										</div>

										<div class="form-group">
											<input name="iconf_value" class="form-control" size="25" placeholder="Value" type="text">
										</div>

									  <div class="form-group">
											{!! Form::select('iconf_item_id', $item_list, '', ['class'=>'form-control']) !!}
										</div>

										<div class="form-group">
											<button class="btn btn-success btn-single"><i class="fa fa-plus"></i></button>
										</div>

									{!! Form::close() !!}

								</div>
							</div>

<!-- Responsive Table -->
							<div class="table-responsive tbl-border" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

	@if(count($prodConfigs['itemConfig']) > 0)

	<form action="{{ url('/item-configurations/bulk-update') }}" method="POST">
		  {!! Form::token(); !!}
					{!! Form::hidden('iconf_product_id',$product->id) !!}

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
									@foreach($prodConfigs['itemConfig'] as $iconf)
										<tr>
											<td><input name="iconf_id[]" class="iconf-{{ $iconf->iconf_id }} form-control" type="hidden" value="{{ $iconf->iconf_id }}" />{{ $iconf->iconf_id }}</td>
											<td><input name="iconf_name[]" class="iconf-{{ $iconf->iconf_id }} form-control" readonly type="text" value="{{ $iconf->iconf_name }}" /></td>
											<td><input name="iconf_value[]" class="iconf-{{ $iconf->iconf_id }} form-control" readonly type="text" value="{{ $iconf->iconf_value }}" /></td>
											<td>
											{!! Form::select('iconf_item_id[]', $item_list, $iconf->iconf_item_id, ['readonly'=>'true','class'=>'form-control iconf-'.$iconf->iconf_id]) !!}
											</td>
											<td><select name="iconf_status[]" class="iconf-{{ $iconf->iconf_id }} form-control" readonly>
												<option @if($iconf->iconf_status == 0) selected @endif value="0">InActive</option>
												<option @if($iconf->iconf_status == 1) selected @endif value="1">Active</option>
													</select>
											</td>
											<td><a id="iconf-{{ $iconf->iconf_id }}" class="btn btn-blue form-control btn-iconf edit-fields"><i class="fa fa-edit"></i></a>
											<a href="{{ url('item-configurations/'.$iconf->iconf_id.'/delete-item-config') }}" onclick="return confirm('{{ $dictionary['delete_confirm_alert'] }}')" class="btn btn-red form-control btn-iconf">
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
