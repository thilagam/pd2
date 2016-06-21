@extends('../app')
@section('content')

<style>
.alert-danger { background:#CC3F44 !important; }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
<form>
              <div class="row">
              <div class="col-sm-6">
                  <div class="form-group">
                      <lable>Upload By</label>
                      <input type="text" readonly placeholder="{{ $upload->userby->up_first_name }} {{ $upload->userby->up_last_name }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Date/Time</label>
                      <input type="text" readonly placeholder="{{ $upload->upload_date }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Type</label>
                      <input type="text" readonly placeholder="{{ $upload->upload_date }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Name</label>
                      <input type="text" readonly placeholder="{{ $upload->upload_name }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Original Name</label>
                      <input type="text" readonly placeholder="{{ $upload->upload_original_name }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Description</label>
                      <input type="text" readonly placeholder="{{ $upload->upload_description }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Url</label>
                      <input type="text" readonly placeholder="{{ $upload->upload_url }}" class='form-control' />
                  </div>
              </div>

            <div class="col-sm-6">

                <div class="form-group">
                    <lable>Client</label>
                    <input type="text" readonly placeholder="{{ $upload->clientby->up_company_name }}" class='form-control' />
                </div>
                <div class="form-group">
                    <lable>Product</label>
                    <input type="text" readonly placeholder="{{ $upload->productname->prod_name }}" class='form-control' />
                </div>
                <div class="form-group">
                    <lable>Item</label>
                    <input type="text" readonly placeholder="@if(isset($upload->itemname->item_name)) {{ $upload->itemname->item_name }} @endif" class='form-control' />
                </div>
                <div class="form-group">
                    <lable>Verification Status</label>
                    <input type="text" readonly placeholder="@if($upload->upload_verification_status == 1)  Active @else In-Active @endif" class='form-control' />
                </div>
                <div class="form-group">
                    <lable>Verification By</label>
                    <input type="text" readonly placeholder="@if($upload->upload_verification_status == 1) {{ $upload->verifyby->up_first_name }} {{ $upload->verifyby->up_last_name }} @endif" class='form-control' />
                </div>
                <div class="form-group">
                    <lable>Verification Msg</label>
                    <input type="text" readonly placeholder="@if($upload->upload_verification_status == 1) {{ $upload->upload_verification_msg }} @endif" class='form-control' />
                </div>
                <div class="form-group">
                    <lable>Status</label>
                    <input type="text" readonly placeholder="@if($upload->upload_status == 1)  Active @else In-Active @endif" class='form-control' />
                </div>
            </div>
          </div>
         @if(count($comparedArray) > 0)
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
        @endif

</form>
</div>
</div>
</div>
</div>

@stop
