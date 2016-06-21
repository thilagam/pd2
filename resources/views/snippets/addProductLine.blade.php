<div class="row" id='row_{{ $id }}'>
		{!! Form::hidden('pid[]', null , array('id' => 'pid_'.$id)) !!}				
		<div class="col-md-5">
			<div class="form-group">
				{!! Form::label($dictionary['cl_product_name'], $dictionary['cl_product_name'],['class'=>'control-label']) !!}
									
				<input class="form-control" name="product_name[]" id="product_name_1" data-validate="require" placeholder="product name" />
			</div>
		</div>
		
		<div class="col-md-5">
			<div class="form-group">
				{!! Form::label($dictionary['cl_boincharge'], $dictionary['cl_boincharge'],['class'=>'control-label']) !!}
									
				<script type="text/javascript">
					//jQuery(document).ready(function($)
					//{
						
					//});
				</script>
				{!! Form::select('boincharge[]',
			        			    $bouserData,
								   	null,
								    [	
									'class'=>'form-control',
									'id'=>'boincharge_'.$id,
									'data-validate'=>'required',
									'placeholder'=>'select bouser'
								    ]
			        			) 
			        !!}
				
			</div>
		</div>
		
		
		<div class="col-md-1"  id="min_{{ $id }}">

			<div class="form-group">
				<label class="control-label" for="job_positi"> &nbsp;</label>
				<button id="remove_{{ $id }}" type="button" class="btn btn-danger btn-single form-control col-md-2 removeProductLine">-</button>
				
			</div>
		</div>
		<div class="col-md-1" id='plus_{{ $id }}'>

			<div class="form-group">
				<label class="control-label" for="job_positi"> &nbsp;</label>
				<button type="button" class="btn btn-info btn-single form-control col-md-2 addProductLine">+</button>
				
			</div>
		</div>
		
	</div>
						
							