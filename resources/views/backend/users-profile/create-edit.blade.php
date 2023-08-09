@extends('backend.layouts.app')
@push('style')
@endpush
@section('content')

    <section class="content-header p-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <label class=" text-capitalize" style="font-size: 30px;">
                        Profile
                    </label>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item text-capitalize active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="col-md-6">
        <a href="{{ route('admin.gymer.index') }}" class=" btn btn-secondary"><i class="fas fa-arrow-left"> </i></a><br><br>
    </div>
    <div class="row mb-5">
        <div class="col-md-6 ">
            <label class=" ml-3  ">Name : <span class=""> {{ $datas[0]->name }}</span></label><br>
            <label class=" ml-3  ">Phone : <span class=""> {{ $datas[0]->phone }}</span></label><br>
            <label class=" ml-3  ">Monthly Fee : Rs <span class=""> {{ $fee }}</span></label><br>
            <label class=" ml-3  ">Discount : <span class=""> {{ $add_discount }} %</span></label><br>
            <label class=" ml-3  ">Fee after Discount : Rs <span class="">{{ $total_fee }}</span></label>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('uploads/gymer/' . $datas[0]->image) }}" class="float-right rounded" alt="Please Insert Image"
                srcset="" style="max-height:125px;">
        </div>
    </div>
    @include('backend.message.info')
    <div class="card shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h2 class="text-success text-center"> Payment Types</h2>
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.anual_paymenttype.store') }}" method="post">
                        @csrf
                        <label class="form-label">Select Payment Type</label>
                        <select name="payment_type" id="" class="form-control" required>
                            <option value="">Select Payment Type</option>
                            @foreach ($payment_types as $payment_type)
                                <option value="{{ $payment_type->id }} "> <span
                                        class="mr-5">{{ $payment_type->payment_name }} </span><span
                                        class="ml-3">({{ $payment_type->discount }}% </span>) Discount</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="user" id="" value="{{ $datas[0]->id }}">
                        <center>
                            <button type="submit" class="btn btn-success btn-sm mt-3 ">Submit</button>
                        </center>
                    </form>
                </div>

                <div class="col-md-6">
                    <div class="container">
                        <h5 class="text-center">Selected Payment Type </h5>
                        <ul class="list-group mb-2 bg-dark text-light">
                            @foreach ($user_haspaymenttype as $payment_type)
                                <li class="list-group-item bg-dark text-light">
                                    <label class=""> Payment Name: </label> <label class="ml-2">
                                        {{ $payment_type['anual_payment']->payment_name }} </label> <label class="ml-5">
                                        <form action="{{ route('admin.delete.paymenttype', $payment_type->slug) }}"
                                            method="get">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm ml-5 btn-outline-danger  conf_anuual float-end"
                                                data-toggle="tooltip" title='Delete'><i class="fas fa-trash"></i></button>
                                        </form>
                                    </label>
                                </li>
                                <li class="list-group-item bg-dark text-light">
                                    <label class=""> Discount : </label><label class=" ml-2">
                                        {{ $payment_type['anual_payment']->discount }} %</label></label> <label
                                        class=" ml-5"> <b> Payment Amount : </b> Rs.
                                        {{ $payment_type['anual_payment']->total_amount }} </label>
                                </li>
                                <li class="list-group-item bg-dark text-light">
                                    <label class=""> start Date : </label> <label class=" ml-2">
                                        {{ date('Y-M-d', strtotime($payment_type->start_date)) }} </label> <label
                                        class="ml-5 "><b>Expiry Date : </b>
                                        {{ date('Y-M-d', strtotime($payment_type->end_date)) }} </label>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h2 class="text-success text-center">Offers Type</h2>

            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.user_offer.store') }}" method="post">
                        @csrf
                        <label class="form-label">Select Offer</label>
                        <select name="offer" id="" class="form-control" required>
                            <option value="">Select offer</option>
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" readonly name="user" id="" value="{{ $datas[0]->id }}">
                        <center>
                            <button type="submit" class="btn btn-success btn-sm mt-3 ">Submit</button>
                        </center>
                    </form>
                </div>

                <div class="col-md-6">
                    <div class="container">
                        <h5 class="text-center">Selected Offer </h5>
                        <ul class="list-group mb-2">

                            @foreach ($user_hasoffer as $offer)
                                <li class="list-group-item bg-dark text-light">
                                    <label class=""> <b class="mr-2">Name : </b> {{ $offer['offer']->name }}
                                    </label> <label class="ml-5 ">
                                        <form action="{{ route('admin.delete.offer', $offer->slug) }}" method="get">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger conf_offer float-end ml-5"
                                                data-toggle="tooltip" title='Delete'><i
                                                    class="fas fa-trash "></i></button>
                                        </form>
                                    </label>
                                </li>
                                <li class="list-group-item bg-dark text-light">
                                    <label class=""> <b class="mr-2">Discount :</b>
                                        {{ $offer['offer']->discount }} %</label>
                                </li>
                                <li class="list-group-item bg-dark text-light">
                                    <label class=" mr-3"><b class="mr-2"> Joined Date : </b>
                                        {{ date('Y-M-d', strtotime($offer->created_at)) }} </label>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h2 class="text-success text-center"> Gymer Group</h2>
            <div class="row ">
                <div class="col-md-6 mb-5">
                    <div class="container">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h4 class="text-center ">Add Gymer into Group</h4>
                        <form method="post" action="{{ route('admin.users_profile.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="input-group control-group increment">
                                <input type="hidden" value="{{ $user_group }}" name="user_group">
                                <select name="demos[]" id="" class="form-control" required>
                                    <option value="">Select Gymer</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                                    @endforeach

                                </select>

                                <input type="hidden" name="user" id="" value="{{ $datas[0]->id }}">
                                <div class="input-group-btn">
                                    <button class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                </div>
                            </div>
                            <div class="clone hide">
                                <div class="control-group input-group" style="margin-top:10px">
                                    <select name="demos[]" id="" class="form-control" required>
                                        <option value="">Select Gymer</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger" type="button"><i
                                                class="glyphicon glyphicon-remove"></i> Remove</button>
                                    </div>
                                </div>
                            </div>
                            <center> <button class="btn btn-primary btn-sm m-2" type="submit">Sumbit</button></center>
                        </form>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="container">
                        <h3 class="text-center"> Group Table</h3>
                        <label> Group Discount : @if ($discount != '')
                                <label class="text-info"> {{ $discount }} %</label>
                            @endif
                        </label><br>
                        <ul class="list-group">
                            @foreach ($user_hasgroup as $group)
                                <li class="list-group-item bg-dark text-light">
                                    <label class=""> <b class="mr-2"> Name:</b>
                                        {{ $group['user_hasgroup']->name }} </label>
                                    <label class="ml-3"> <b>Phone :</b>
                                        {{ $group['user_contact']->phone }}
                                    </label>
                                    <a href="{{ route('admin.delete.group', $group->slug) }}"
                                        class="float-right  btn btn-danger btn-sm " onclick="ConfirmDelete()"><i
                                            class="fas fa-trash "></i>
                                    </a>

                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('.conf_anuual').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, Please  Update The amount in the payment History.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });

        $('.conf_offer').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
        $('.conf_group').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(".btn-success").click(function() {
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click", ".btn-danger", function() {
                $(this).parents(".control-group").remove();
            });

        });
        setTimeout(function() {
            $('#mydiv').fadeOut('fast');
        }, 5000);
    </script>
@endpush
