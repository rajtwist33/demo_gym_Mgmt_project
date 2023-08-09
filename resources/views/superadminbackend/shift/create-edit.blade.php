<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="name">Shift Name</label>
      <input type="text" class="form-control" name="shift_name" id="shift_name" value="{!! $data_list->shift_name ?? old('shift_name') !!}" autofocus autocomplete="off"> 
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label for="name">Start Time</label>
      <input type="time" class="form-control" name="starttime" id="starttime" value="{!! $data_list->starttime ?? old('starttime') !!}" autofocus autocomplete="off"> 
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label for="name">End Time</label>
      <input type="time" class="form-control" name="endtime" id="endtime" value="{!! $data_list->endtime ?? old('endtime') !!}" autofocus autocomplete="off">
    </div>
  </div>
</div>
<input type="hidden" name="data_id" value="{!! $data_list->id ?? '' !!}">
