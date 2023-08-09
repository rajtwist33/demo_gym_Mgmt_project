<div class="row">
    <div class="col-md-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{!! $data_list->name ?? old('name') !!}"
                        autofocus autocomplete="off">
                    <span id="error_name" class="text-danger"></span>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{!! $data_list->email ?? old('email') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Address</label>
                    <input type="text" class="form-control" name="address" id="address"
                        value="{!! $data_list ? $data_list['getUserDetail']->address : '' ?? old('address') !!}" autocomplete="off">
                    <span id="error_address" class="text-danger"></span>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Phone</label>
                    <input type="number" class="form-control" name="phone" id="phone"
                        value="{!! $data_list ? $data_list['getUserDetail']->phone : '' ?? old('phone') !!}" autocomplete="off">
                    <span id="error_phone" class="text-danger"></span>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Card No </label>
                    <input type="text" class="form-control" name="card_no" id="card_no"
                        value="{!! $data_list['getUserDetail']->card_no ?? old('card_no') !!}" autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="blood_type"> Blood Type</label>
                    <select class="custom-select" name="blood_type" id="blood_type">
                        <option value=""> -- Select the Blood Type -- </option>
                        @foreach ($blood_types as $bitem)
                            <option value="{{ $bitem->id }}" @selected($data_list ? $data_list['getUserDetail']->blood_type == $bitem->id : '' ?? old('blood_type'))>{{ $bitem->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="age"> Age</label>
                    <input type="number" class="form-control" name="age" id="age"
                        value="{!! $data_list ? $data_list['getUserDetail']->age : '' ?? old('age') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Gender</label>
                    <div class="row">
                        @foreach ($genders as $key => $gitem)
                            <div class="custom-control custom-radio ml-3">
                                <input class="custom-control-input" type="radio" id="{{ $gitem->slug }}"
                                    name="gender" value="{{ $gitem->id }}" @checked($data_list ? $data_list['getUserDetail']->gender == $gitem->id : '' ?? old('gender'))
                                    @checked($key == 0)>
                                <label for="{{ $gitem->slug }}"
                                    class="custom-control-label">{{ $gitem->name }}</label>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> DOB</label>
                    <input type="date" class="form-control" name="dob" id="dob"
                        value="{!! $data_list ? $data_list['getUserDetail']->dob : '' ?? old('dob') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="reffered_by"> Reffered By</label>
                    <select class="custom-select" name="reffered_by" id="reffered_by">
                        <option value=""> -- Choose Person -- </option>
                        @foreach ($reffered_by as $item)
                            <option value="{{ $item->id }}" @selected($data_list ? $data_list['getUserDetail']->reffered_by == $item->id : '' ?? old('reffered_by'))>{!! $item->name !!}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="row">

            <div class="col-12">
                <label for="text"> Weight</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">kg</div>
                    </div>
                    <input type="number" class="form-control" name="weight" id="weight"
                        value="{!! $data_list ? $data_list['getUserDetail']->weight : '' ?? old('weight') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <label for="name"> Height</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Feet</div>
                    </div>
                    <input type="number" class="form-control" name="height" id="height"
                        value="{!! $data_list ? $data_list['getUserDetail']->height : '' ?? old('height') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Guardian Name</label>
                    <input type="text" class="form-control" name="parent_name" id="parent_name"
                        value="{!! $data_list ? $data_list['getUserDetail']->parent_name : '' ?? old('parent_name') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="number"> Guardian Number</label>
                    <input type="text" class="form-control" name="parent_number" id="parent_number"
                        value="{!! $data_list ? $data_list['getUserDetail']->gaurdian_number : '' ?? old('parent_number') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Payment Amount (Per Shift)</label>
                    <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control"
                        name="payment_amount" id="payment" value="{!! $data_list['getUserDetail']->payment ?? old('payment') !!}" autocomplete="off">
                    <span id="error_payment" class="text-danger"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Joining Date</label>
                    <input type="date" class="form-control" name="join_date" id="join_date"
                        value="{!! $data_list->join_date ?? old('join_date') !!}" autocomplete="off">
                    <span id="error_joindate" class="text-danger"></span>
                </div>
            </div>
            <div class="col-12">
                @if ($data_list->id ?? '')
                    <img src="{{ asset('uploads/trainer/' . $data_list['getUserDetail']->image) }}"
                        alt="preview image" style="max-height: 125px;">
                @endif
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" class="d-block" name="image" id="image"
                        value="{!! $data_list['getUserDetail']->image ?? old('image') !!}" autocomplete="off">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" class="custom-control-input" name="insurence" id="insurence"
                            @checked($data_list ? $data_list['getUserDetail']->insurence : '' ?? old('insurence'))>
                        <label class="custom-control-label" for="insurence">Do you have insurance?</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="data_id" value="{!! $data_list->id ?? '' !!}">
