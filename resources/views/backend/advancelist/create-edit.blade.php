<div class="row">
  <div class="col-md-12">
    <div class="row">
    
      <div class="col-12">
        <label for="" class="fs-1"><span class="fs-1 text-primary">Name :</span>
          <strong class="text-danger fs-1">
            {{ $data_advance['getUser']->name }}
          </strong>
       </label>
      
        <div class="form-group">
          <label for="name"> Amount</label>
          <input type="number" class="form-control" name="initial_advance" id="initial_advance" value="{!! $data_advance->initial_advance ?? old('initial_advance') !!}" autocomplete="off"> 
        </div>
      </div> 
    </div>
  </div>
</div>
<input type="hidden" name="data_id" value="{{  $data_advance->id ?? '' }}">
