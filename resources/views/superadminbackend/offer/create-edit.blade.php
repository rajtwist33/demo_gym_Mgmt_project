<div class="row">
    <div class="col-md-12">
   <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Offer Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{!! $data_list->name ?? old('name') !!}" autofocus autocomplete="off">
       <span id="error_name"></span>
            </div>
        </div>
        <div class="col-md-6 ">
            <label for="">Discount</label>
            <div class="input-group ">
                <div class="input-group-prepend">
                  <div class="input-group-text">%</div>
                </div>
                <input type="number" class="form-control" min="0" oninput="validity.valid||(value='');" name="discount" id="discount" value="{!! $data_list->discount ?? old('discount') !!}" autofocus autocomplete="off">
              </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Start Date</label>
                <input type="date" class="form-control"  name="start_date" id="start_date" min="{{ date('Y-m-d') }}"  value="{!! $data_list->start_date ?? date('Y-m-d') !!}" autocomplete="off">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">End Date</label>
                <input type="date" class="form-control" name="end_date" id="end_date"  min="{{ date('Y-m-d') }}"   value="{!! $data_list->end_date ?? old('end_date') !!}" autofocus autocomplete="off">
            </div>
        </div>
    </div>

    <div class="form-group">
         <label for="name">Package Discription</label>
        <textarea type="text" class=" form-control" name="description" id="description"  autofocus autocomplete="off"> {!! $data_list->description ?? old('description') !!}</textarea>
    </div>

    </div>
  </div>
  <input type="hidden" name="data_id" value="{!! $data_list->id ?? '' !!}">


