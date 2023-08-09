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
                    <label for="shift_id"> Shift</label>
                    <select class="custom-select" name="shift_id" id="shift_id">
                        <option value=""> -- Select the Shift -- </option>
                        @foreach ($shifts as $shift)
                            <option value="{{ $shift->id }}" @selected($data_list ? $data_list['getUserDetail']->shift_id == $shift->id : '' ?? old('shift_id'))>{{ $shift->shift_name }}
                                <span>(</span> <span>{{ date('g:i a', strtotime($shift->starttime)) }}</span><span> -
                                </span> <span>{{ date('g:i a', strtotime($shift->endtime)) }}</span> <span>)</span>
                            </option>
                        @endforeach
                    </select>
                    <span id="error_shift" class="text-danger"></span>
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
                            <div class="col-md-4">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="{{ $gitem->slug }}"
                                        name="gender" value="{{ $gitem->id }}" @checked($data_list ? $data_list['getUserDetail']->gender == $gitem->id : '' ?? old('gender'))
                                        @checked($key == 0)>
                                    <label for="{{ $gitem->slug }}"
                                        class="custom-control-label">{{ $gitem->name }}</label>
                                </div>
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
                <label for="text"> Weight</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">kg</div>
                    </div>
                    <input type="number" class="form-control" name="weight" id="weight"
                        value="{!! $data_list ? $data_list['getUserDetail']->weight : '' ?? old('weight') !!}" autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="row">
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
                <label for="name"> Fee </label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Fee</div>
                    </div>
                    <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control"
                        name="fee" id="fee" value="{!! $data_list ? $data_list['getUserDetail']->fee : '2500' ?? old('fee') !!}" autocomplete="off">
                </div>
                <span id="error_fee" class="text-danger"></span>

            </div>
            <div class="col-12">
                <label for="name"> Admission </label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Admission</div>
                    </div>
                    <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control"
                        name="admission" id="admission" value="{!! $data_list ? $data_list['getUserDetail']->admission : '1500' ?? old('admission') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Joining Date</label>
                    <input type="date" class="form-control" name="join_date" id="join_date"
                        value="{!! $data_list->dumy_join_date ?? old('join_date') !!}" autocomplete="off">
                    <span id="error_joindate" class="text-danger"></span>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="offer_id"> Offers </label>
                    <select class="custom-select" name="offer_id" id="offer_id">
                        <option value=""> -- Select the Offer -- </option>
                        @foreach ($offers as $offer)
                            <option value="{{ $offer->id }}" @selected($data_list ? $data_list['user_hasoffer'] != null && $data_list['user_hasoffer']->offer_id == $offer->id : '' ?? old('offer_id'))>{{ $offer->name }}
                                <span>(</span><span>{{ $offer->discount }}</span><span> % )</span>
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
                <div class="form-group">
                    <label for="name"> Parent Name</label>
                    <input type="text" class="form-control" name="parent_name" id="parent_name"
                        value="{!! $data_list ? $data_list['getUserDetail']->parent_name : '' ?? old('parent_name') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="number"> Guardian Name</label>
                    <input type="text" class="form-control" name="gaurdian_name" id="gaurdian_name"
                        value="{!! $data_list ? $data_list['getUserDetail']->gaurdian_name : '' ?? old('gaurdian_name') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="number"> Guardian Number</label>
                    <input type="text" class="form-control" name="gaurdian_number" id="gaurdian_number"
                        value="{!! $data_list ? $data_list['getUserDetail']->gaurdian_number : '' ?? old('gaurdian_number') !!}" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="name"> Card No / Citizenship No</label>
                    <input type="text" class="form-control" name="card_no" id="card_no"
                        value="{!! $data_list['getUserDetail']->card_no ?? old('card_no') !!}" autocomplete="off">
                </div>
            </div>

            <div class="col-12">
                @if ($data_list->id ?? '')
                    <img src="{{ asset('uploads/gymer/' . $data_list['getUserDetail']->image) }}" alt="Please Insert Image"
                        style="max-height: 125px;">
                @endif
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" class="d-block" name="image" id="image"
                        value="{!! $data_list['getUserDetail']->image ?? old('image') !!}" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
     <div class="col-12">
                <div class="form-group float-left">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input type="checkbox" class="custom-control-input" name="insurence" id="insurence"
                            @checked($data_list ? $data_list['getUserDetail']->insurence : '' ?? old('insurence'))>
                        <label class="custom-control-label" for="insurence">Do you have insurance?</label>
                    </div>
                </div>
            </div>
    <div class="col-6">
        <div class="form-group">
            <label for="number"> Physical Description</label>
            <textarea class="form-control" name="physical_description" id="exampleFormControlTextarea1" rows="3"> {!! $data_list ? $data_list['getUserDetail']->physical_description : '' ?? old('physical_description') !!}</textarea>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="number"> Break Notify</label>
            <textarea class="form-control" name="break_notify" id="exampleFormControlTextarea1" rows="3">{!! $data_list ? $data_list['getUserDetail']->break_notify : '' ?? old('break_notify') !!}</textarea>
        </div>
    </div>
</div>
<input type="hidden" name="data_id" value="{!! $data_list->id ?? '' !!}">
