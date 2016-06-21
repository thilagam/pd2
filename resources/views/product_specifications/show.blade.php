@extends('../app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

    <form >
        <div class="form-group">
                <label for="">Product</label>
                <select class="form-control" readonly>
                    @foreach($all_ps_products as $key=>$prd)
                        <option value="1" @if ($productSpecs->specprod_product_id == $key) selected @endif >{{ $prd }}</option>
                    @endforeach    
                </select> 
        </div>
        <div class="form-group">
                <label for="">Item</label>
                {!! Form::select('specprod_item_id', array('link_pdn' => $dictionary['link_pdn'], 'link_ref' => $dictionary['link_ref'], 'link_ftp_references' => $dictionary['link_ftp_references'], 'link_delivery'=>$dictionary['link_delivery'],'link_writer'=>$dictionary['link_writer']),$productSpecs->specprod_item_id, ['class'=>'form-control','id'=>'item_name_type','readonly'=>'readonly']) !!}
        </div>
        <div class="form-group">
                <label for="">Url</label>
                <input type="text" class="form-control" placeholder="{{$productSpecs->specprod_url}}" readonly>
        </div>
        <div class="form-group">
                <label for="">Language</label>
                <select class="form-control" readonly>
                    @foreach($languages_array as $key=>$lang)
                        <option value="{{ $key }}" @if ($productSpecs->specprod_language_code == $key) selected @endif >{{ $lang }}</option>
                    @endforeach    
                </select> 
        </div>
        <div class="form-group">
                <label for="">Reference Column</label>
                <select class="form-control" readonly>
                    @for($i=1;$i<27;$i++)
                        <option value="{{ $i }}" @if ($productSpecs->specprod_product_id == $i) selected @endif >{{ chr(65+$i) }}</option>
                    @endfor    
                </select> 
        </div>
        <div class="form-group">
                <label for="">Usage</label>
                <textarea class="form-control" rows="3" placeholder="{{$productSpecs->specprod_usage}}" readonly></textarea>
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea class="form-control" rows="3" placeholder="{{$productSpecs->specprod_description}}" readonly></textarea>
        </div>
        <div class="form-group">
            <label for="">Technical Info</label>
            <textarea class="form-control" rows="3" placeholder="{{$productSpecs->specprod_technical_info}}" readonly></textarea>
        </div>

@if($productSpecs->specprod_attachment_id > 0)
<div class="form-group">
<!-- <label class="col-sm-2 control-label" for="field-1">Template</label> -->
            <label for="Attachment">Attachment</label>

@foreach($prd_attachment as $att)
<div style="padding:1% 0%">

<a href="/download/{{ Crypt::encrypt($att->attfiles_path) }}/s"><i class="fa fa-download" style="padding-right:2%"></i> <span>  {{ $att->attfiles_original_name }}</span></a>

</div>
@endforeach

</div>
@endif


        <div class="form-group">
            <label for="" >Status</label>
			<select class="form-control" readonly>
					<option value="1" @if ($productSpecs->specprod_status == 1) selected @endif >Active</option>
				    <option value="0" @if ($productSpecs->specprod_status == 0) selected @endif >In Active</option>
			</select> 	
        </div>
        <div class="form-group">
                <a href="{{ url('product-specifications')}}" class="btn btn-purple pull-right">Back</a>

        </div>
    </form>

</div>
</div>
</div>
</div>

@stop
