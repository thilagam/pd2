@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

                                <style type="text/css">
                                            .myFile {
                                              position: relative;
                                              overflow: hidden;
                                              float: left;
                                              clear: left;
                                            }
                                            .myFile input[type="file"] {
                                              display: block;
                                              position: absolute;
                                              top: 0;
                                              right: 0;
                                              opacity: 0;
                                              font-size: 100px;
                                              filter: alpha(opacity=0);
                                              cursor: pointer;
                                            }
                                </style>

      @include('blocks.error_block')
     {!! Form::open(['url' => 'product-specifications', 'files'=>true]) !!}
    <div class="form-group">
        {!! Form::label('Product', 'Product:') !!}
        {!! Form::select('specprod_product_id',$all_ps_products,null, ['class'=>'form-control','id'=>'item_name_type']) !!}
     </div>
    <div class="form-group">
        {!! Form::label('Items', 'Items:') !!}
        {!! Form::select('specprod_item_id', array('link_pdn' => $dictionary['link_pdn'], 'link_ref' => $dictionary['link_ref'], 'link_ftp_references' => $dictionary['link_ftp_references'], 'link_delivery'=>$dictionary['link_delivery'],'link_writer'=>$dictionary['link_writer']),null, ['class'=>'form-control','id'=>'item_name_type']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Url', 'Url:') !!}
        {!! Form::text('specprod_url',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language', 'Language:') !!}
        {!! Form::select('specprod_language_code',$languages_array,null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Reference Column', 'Reference Column:') !!}
        {!! Form::select('specprod_reference_id',$alphaRange,1,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Usage', 'Usage:') !!}
        {!! Form::textarea('specprod_usage',null,['class'=>'form-control','rows'=>'3']) !!}
    </div>
        <div class="form-group">
        {!! Form::label('Description', 'Description:') !!}
        {!! Form::textarea('specprod_description',null,['class'=>'form-control','rows'=>'3']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Technical Info', 'Technical Info:') !!}
        {!! Form::textarea('specprod_technical_info',null,['class'=>'form-control','rows'=>'3']) !!}
    </div>

<div class="form-group" style="margin-bottom:5%;">
<!-- <label class="col-sm-2 control-label" for="field-1">Template</label> -->
{!! Form::label('Attachment', 'Attachment') !!}

<div class="">
<label class="myFile">
<div class="btn btn-primary btn-icon btn-icon-standalone">
<i class="fa-upload"></i>
 <input type="file" name="files[]" class="btn btn-default" id="template" placeholder="{{ $dictionary['placeholder_upload'] }}" multiple /> 
<!-- {!! Form::file('file[]','',['class'=>'', 'id'=>'template', 'placeholder'=>$dictionary['placeholder_upload'], 'multiple'=>true ]) !!} -->
<span>Upload </span>
</div>
</label>
</div>
</div>

    <div class="form-group">
        {!! Form::checkbox('universal_id',1,false) !!}
        {!! Form::label('Convert Url ID to DD', 'Convert Url ID to DD') !!}
    </div>
    <div class="form-group">
        <a href="{{ url('product-specifications')}}" class="btn btn-purple">Back</a> 
        {!! Form::submit('Save', ['class' => 'btn btn-info btn-single  pull-right']) !!}
	    {!! Form::reset('Reset', ['class' => 'btn btn-orange btn-single  pull-right']) !!}

    </div>
    {!! Form::close() !!}

</div>
</div>
</div>
</div>

@stop
