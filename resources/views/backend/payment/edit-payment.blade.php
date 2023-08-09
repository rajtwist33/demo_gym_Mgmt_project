<div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-12">
          <label for="" class="fs-1 mb-2"><span class="fs-1 text-primary">Name :</span>
            <strong class="text-danger fs-1">
              {{ $user_info->name }}
            </strong>
          </label>    
            @if($user_info->id )
            <span class="float-right m-1">
            <img  src="{{ asset('uploads/gymer/'.$user_info->image)  }}"
            alt="preview image" style="max-height: 75px;">
          </span>
          @endif
        </div>
        <div class="col-12">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group ">
                <label for="amount">Actual  Amount</label>
                <input type="number" class="form-control" name="amount" id="amount"  value="{{ $user_info->amount }}" autocomplete="off"> 
              </div>
            </div>    
            <div class="col-md-6 mt-2">
              <label ></label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Paid Date </div>
                </div>
                <input type="date" class="form-control"  name="date"  value="{!! $user_info->date !!}" autocomplete="off">
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <input type="hidden" name="users" id="" value="{{ $user_info->user_id }}">
  <input type="hidden" name="data_id" value="{!! $user_info->id ?? '' !!}">
  