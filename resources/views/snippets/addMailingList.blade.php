<div id="row_{{ $id }}">
	<div class="form-group">
		{!! Form::label($dictionary['email'], $dictionary['email'],['class'=>'col-sm-2 control-label']) !!}
		<div class="col-sm-5">
				{!! Form::text('emails[]',null ,['class'=>'form-control','id'=>'email_{{ $id }}','data-validate'=>'required','placeholder'=>$dictionary['email']]) !!}
		</div>
		<div class="col-sm-1"  id="min_{{ $id }}">

			<div class="form-group">
				<button id='cannot_{{ $id }}' type="button" class="btn btn-danger btn-single form-control col-md-2 removeProductLine">-</button>
				
			</div>
		</div>

		<div class="col-sm-1" id='plus_{{ $id }}'>

			<div class="form-group">
				<button type="button" class="btn btn-info btn-single form-control col-md-2 addProductLine" style="margin-left:20px;">+</button>
			</div>
		</div>	
	</div>
</div>