<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Payment Type</label>
                    <input type="text" class="form-control" name="name" id="name" value="{!! $data_list->payment_name ?? old('name') !!}" autofocus autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Set Monthly Amount </label>
                    <input type="number" min="1" oninput="validity.valid||(value='');" class="form-control" name="set_amount" id="set_amount" value="{!! $data_list ? ($data_list->set_amount): '2500' ?? old('set_amount') !!}" autofocus autocomplete="off">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Number Of Month</label>
                    <input type="number" min="1" max = "12" oninput="validity.valid||(value='');" class="form-control" name="no_month" id="no_month" value="{!! $data_list->no_month ?? old('no_month') !!}" autofocus autocomplete="off">
                </div>
            </div>
            <div class="col-md-6 ">
                <label for="">Discount</label>
                <div class="input-group ">
                    <div class="input-group-prepend">
                    <div class="input-group-text">%</div>
                    </div>
                    <input type="number" min="1" max ="100" oninput="validity.valid||(value='');" class="form-control" name="discount" id="discount" value="{!! $data_list->discount ?? old('discount') !!}" autofocus autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Monthly_amount (with Discount)</label>
                    <input type="number"  min="1" oninput="validity.valid||(value='');" class="form-control" name="monthly_amount" id="monthly_amount" value="{!! $data_list->monthly_amount ?? old('monthly_amount') !!}" autofocus autocomplete="off" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Total Amount (with No. Months)</label>
                    <input type="number" min="1" oninput="validity.valid||(value='');" class="form-control" name="amount" id="amount" value="{!! $data_list->total_amount ?? old('amount') !!}" autofocus autocomplete="off" readonly>
                </div>
            </div>
         </div>
    </div>
 </div>
  <input type="hidden" name="data_id" value="{!! $data_list->id ?? '' !!}">


