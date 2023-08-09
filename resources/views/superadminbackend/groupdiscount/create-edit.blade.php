<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="name">No of Gymer</label>
      <div class="input-group ">
        <input type="number" class="form-control" min="1" oninput="validity.valid||(value='');" name="no_gymer" id="no_gymer" value="{!! $data_list->no_gymer ?? old('no_gymer') !!}" autofocus autocomplete="off"> 
        <div class="input-group-prepend">
          <div class="input-group-text">Persons</div>
        </div>
      </div>
    </div>

  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label for="no_gymer">Discount Percent </label>
      <div class="input-group ">
        <div class="input-group-prepend">
          <div class="input-group-text">%</div>
        </div>
        <input type="number" class="form-control" min="1" max="100" oninput="validity.valid||(value='');" name="discount" id="discount" value="{!! $data_list->discount ?? old('discount') !!}" autofocus autocomplete="off"> 
      </div>
    </div>
  </div>
 
</div>
<input type="hidden" name="data_id" value="{!! $data_list->id ?? '' !!}">
