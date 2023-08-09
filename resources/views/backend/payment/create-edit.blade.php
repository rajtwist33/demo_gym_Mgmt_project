<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-12">
        <label for="" class="fs-1"><span class="fs-1 text-dark">Name :</span>
          <strong class="text-danger fs-1">
            {{ $user_info->name }}
          </strong>
        </label><br>
        <label for="" class="fs-1"><span class="fs-1 text-dark">Mobile No :</span>
          <strong class="text-danger fs-1">
            {{ $user_info->getUserDetail->phone }}
          </strong>
        </label>

            @if($user_info->id ?? '')
            <span class="float-right mr-1 ">
            <img  src="{{ asset('uploads/gymer/'.$user_info['getUserDetail']->image)  }}"
            alt="Please Insert Image" style="max-height: 75px;">
          </span>
          @endif

      </div>
      <div class="col-12">

      @if($user_haspaymenttype->count() > 0)
        @foreach($user_haspaymenttype as $paymentype)
            <h2>You have {{  $paymentype['anual_payment']->payment_name  }} Payment </h2>
            <small class="text-center text-danger">To see Details go to Profile Section</small>
        @endforeach
      @else
      <div class="row">

        <div class="col-md-6">
            <div class="form-group">
              <label for="name"> Total Paying Amount</label>
              <input type="number"  min="0"  oninput="this.value = Math.abs(this.value)"  class="form-control" name="amount" id="amount"  value="{{ $check_last_paid_month == false ? $total_fee : abs($credit) }}" oninput="display(this)" autocomplete="off" required >
              <input type="hidden" readonly  oninput="this.value = Math.abs(this.value)"  class="form-control" name="backup_advance" id="amount"  value="{{$data}}" oninput="display(this)" autocomplete="off"  >
            </div>

        </div>
          <div class="col-md-6 mt-4">
            <div class="input-group mt-2">
              <div class="input-group-prepend">
                <div class="input-group-text ">Paid Date </div>
              </div>
              <input type="date" class="form-control"  name="date" max="{!! date('Y-m-d') !!}" value="{!! date('Y-m-d') !!}" autocomplete="off">
            </div>
          </div>
      </div>

        @endif
      <hr>
        <div class="row">
          <div class="col-12">
            <div class="row mt-3">
              <div class="col-md-4">
                <b>Due : <span class="text-danger">{{ abs($credit) }}</span></b>
              </div>
              <div class="col-md-4">
                <b> Deposit : <span class="text-success">{{ $debit }}</span></b>
              </div>
              <div class="col-md-4">
                <b>Advance : <span class="text-success">{{ $remain }}</span></b>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="users" value="{!! $user_info->id ?? '' !!}">

