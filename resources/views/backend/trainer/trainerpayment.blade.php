<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <label for="">Name: <strong class="ml-3"> {{$data_list->name}}</strong></label>
      </div>
      <div class="col-md-4"><label for="">Address: <strong class="ml-3"> {{$data_list->getUserDetail->address}}</strong></label></div>
      <div class="col-md-4"><label for="">Phone: <strong class="ml-3"> {{$data_list->getUserDetail->phone}}</strong></label></div>
      <div class="col-md-4"><label for="">Shift: <strong class="ml-3">
        @if (count($trainershifts) > 0)
        <ol class="ml-3">
              @foreach($trainershifts as $trainershift)
              <li>{{$trainershift->shifts->shift_name}} <span>( {{$trainershift->shifts->starttime}} -</span> <span>{{$trainershift->shifts->endtime}})</span></li>

              @endforeach
        </ol>
          @endif</strong></label></div>

    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label for="month" class="form-label">Paying Month Name</label>
        <input type="month" value="" class="form-control" name="month" id="month"   max="<?php echo date('Y-m', strtotime('+2 days')); ?>" aria-describedby="emailHelp">
        <span id="error_month" class="text-danger" style="border:none"></span>
      </div>

    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label for="presentdaypresentday" class="form-label">Present Days</label>
        <input type="text" value="" class="form-control" name="presentday" id="presentday"  aria-describedby="emailHelp" >
        <span id="error_presentday" class="text-danger"></span>
      </div>
    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label for="rate" class="form-label">Rate Per Shift</label>
        <input type="text" value="{{$data_list->getUserDetail->payment}}" class="form-control" name="rate" id="rate" onkeydown="result()" aria-describedby="emailHelp" >
        <span id="error_rate" class="text-danger"></span>
      </div>
    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label for="no_shift" class="form-label">Total Number of  Shift</label>
        <input type="num"   class="form-control" onkeyup="result()" name="no_shift" id="no_shift" onkeydown="result()" aria-describedby="emailHelp" >
        <span id="error_shift" class="text-danger"></span>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="amount" class="form-label"> Amount</label>
        <input type="text" value="" class="form-control" name="amount" id="amount" aria-describedby="emailHelp">
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="advance" class="form-label"> Advance Amount</label>
        <input type="text" value="" class="form-control" onkeyup="finalamount()"  name="advance" id="advance" aria-describedby="emailHelp">
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="description" class="form-label"> Sort Description (Optional)</label>
        <textarea name="description" class="form-control"  cols="30" rows="2"></textarea>

      </div>
    </div>
    <div class="col-md-12">
      <div class="row justify-content-center">
      <div class="col-md-4">
      <div class="mb-3">
        <h4 for="net_amount" class="form-label text-primary text-center">Net Amount</h4>
        <input type="text" value="" class="form-control" name="net_amount" id="net_amount" aria-describedby="emailHelp">
      </div>
      </div>
      </div>
    </div>
  </div>
  <input type="hidden" class="form-control" value="{{$data_list->id}}" name="data_id" id="data_id" aria-describedby="emailHelp">

