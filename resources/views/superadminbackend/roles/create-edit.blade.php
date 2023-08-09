<div class="form-group">
  <label for="name">Role Name</label>
  <input type="text" class="form-control" name="name" id="role" value="{!! $data_list->role_name ?? old('role') !!}">
</div> 
<input type="hidden" name="data_id" value="{!! $data_list->id ?? '' !!}">