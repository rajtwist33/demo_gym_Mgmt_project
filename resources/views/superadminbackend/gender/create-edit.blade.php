<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="name">Gender Name</label>
      <input type="text" class="form-control" name="name" id="name" value="{!! $data_list->name ?? old('name') !!}" autofocus autocomplete="off"> 
    </div>
  </div>
</div>
<input type="hidden" name="data_id" value="{!! $data_list->id ?? '' !!}">