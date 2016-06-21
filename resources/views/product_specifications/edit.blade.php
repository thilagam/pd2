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
    {!! Form::model($productSpecs,['files'=>true,'method' => 'PATCH','route'=>['product-specifications.update',$productSpecs->specprod_id]]) !!}
    {!! Form::hidden('specgen_spec_id',$productSpecs->specprod_spec_id) !!}
    <div class="form-group">
        {!! Form::label('Product', 'Product:') !!}
        {!! Form::select('specprod_product_id',$all_ps_products,$productSpecs->specprod_product_id, ['class'=>'form-control','id'=>'item_name_type']) !!}
     </div>
    <div class="form-group">
        {!! Form::label('Items', 'Items:') !!}
        {!! Form::select('specprod_item_id', array('link_pdn' => $dictionary['link_pdn'], 'link_ref' => $dictionary['link_ref'], 'link_ftp_references' => $dictionary['link_ftp_references'], 'link_delivery'=>$dictionary['link_delivery'],'link_writer'=>$dictionary['link_writer']),$productSpecs->specprod_item_id, ['class'=>'form-control','id'=>'item_name_type']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Url', 'Url:') !!}
        {!! Form::text('specprod_url',$productSpecs->specprod_url,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Language', 'Language:') !!}
        {!! Form::select('specprod_language_code',$languages_array,$productSpecs->specprod_language_code,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Reference Column', 'Reference Column:') !!}
        {!! Form::select('specprod_reference_id',$alphaRange,$productSpecs->specprod_reference_id,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Usage', 'Usage:') !!}
        {!! Form::textarea('specprod_usage',$productSpecs->specprod_usage,['class'=>'form-control','rows'=>'3']) !!}
    </div>
        <div class="form-group">
        {!! Form::label('Description', 'Description:') !!}
        {!! Form::textarea('specprod_description',$productSpecs->specprod_description,['class'=>'form-control','rows'=>'3']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Technical Info', 'Technical Info:') !!}
        {!! Form::textarea('specprod_technical_info',$productSpecs->specprod_technical_info,['class'=>'form-control','rows'=>'3']) !!}
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


@if($productSpecs->specprod_attachment_id > 0)
<div class="form-group">
<!-- <label class="col-sm-2 control-label" for="field-1">Template</label> -->
            <label for="Attachment">Files</label>

@foreach($prd_attachment as $att)
<div style="padding:1% 0%">

<a href="/download/{{ Crypt::encrypt($att->attfiles_path) }}/s"><i class="fa fa-download" style="padding-right:2%"></i> <span>  {{ $att->attfiles_original_name }}</span></a>

</div>
@endforeach

</div>
@endif

<input type="hidden" value="{{ $productSpecs->specprod_attachment_id }}" name="specprod_attachment_id" /> 

    <div class="form-group">
        {!! Form::label('Staus', 'Status:') !!}
        {!! Form::select('specprod_status', array('1' => 'Active', '0' => 'In-Active'), $productSpecs->specprod_status, ['class'=>'form-control']) !!}
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
