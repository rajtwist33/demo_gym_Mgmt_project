
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="name"> Name</label>
      <input type="text" class="form-control" name="admin_name" id="name" value="{!! $data_list->name ?? old('user_admin') !!}" autofocus autocomplete="off"> 
      <span class="text-danger" id="error_name"></span>
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label for="email"> Email</label>
      <input type="email" class="form-control" name="email" id="email" value="{!! $data_list->email ?? old('email') !!}" autofocus autocomplete="off"> 
      <span class="text-danger" id="error_email"></span>
    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
      <label for="password"> Password</label>
      <input type="text" class="form-control" name="password" id="password" value="{!! $data_list->pass_name ?? old('password') !!}" autofocus autocomplete="off"> 
      <span class="text-danger" id="error_password"></span>
    </div>
  </div>
</div>

<input type="hidden" name="data_id" value="{!! $data_list->id ?? '' !!}">