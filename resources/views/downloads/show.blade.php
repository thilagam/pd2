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
                      <lable>Download By</label>
                      <input type="text" readonly placeholder="{{ $download_log->userby->up_first_name }} {{ $download_log->userby->up_last_name }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Date/Time</label>
                      <input type="text" readonly placeholder="{{ $download_log->download_date }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Type</label>
                      <input type="text" readonly placeholder="{{ $download_log->download_type }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Name</label>
                      <input type="text" readonly  placeholder="{{ $download_log->download_name }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Description</label>
                      <input type="text" readonly placeholder="{{ $download_log->download_description }}" class='form-control' />
                  </div>
                  <div class="form-group">
                      <lable>Url</label>
                      <input type="text" readonly placeholder="{{ $download_log->download_url }}" class='form-control' />
                  </div>
              </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <lable>Client</label>
                    <input type="text" readonly placeholder="{{ $download_log->clientby->up_company_name }}" class='form-control' />
                </div>
                <div class="form-group">
                    <lable>Product</label>
                    <input type="text" readonly placeholder="{{ $download_log->productname->prod_name }}" class='form-control' />
                </div>
                <div class="form-group">
                    <lable>Item</label>
                    <input type="text" readonly placeholder="{{ $download_log->itemname->item_name }}" class='form-control' />
                </div>
                <div class="form-group">
                    <lable>Status</label>
                    <input type="text" readonly placeholder="@if($download_log->download_status == 1)  Active @else In-Active @endif" class='form-control' />
                </div>
            </div>
          </div>

         <div class="col-sm-12">
                      <h4>Download Logs</h4>
                      <table class="table table-bordered table-striped">
                      <tr><th>By</th><th>Date</th></tr>
                      @foreach($dlog as $dl)
                          <tr><td>{{ $dl->userby->up_first_name }} {{ $dl->userby->up_last_name }}</td><td>{{ $dl->dlog_time }}</td></tr>
                      @endforeach
                    </table>
         </div>


</form>
</div>
</div>
</div>
</div>

@stop
