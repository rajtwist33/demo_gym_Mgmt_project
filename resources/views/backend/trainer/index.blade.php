@extends('backend.layouts.app')
@push('style')
@endpush
@section('content')
    <section class="content-header p-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" id="modelBtn" class="btn btn-primary text-capitalize" data-toggle="modal"
                        data-target="#myModal">
                        + {{ Request::segment(3) }}
                    </button>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item text-capitalize active">{{ Request::segment(3) }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="myModal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize" id="exampleModalLabel ">Creating {{ Request::segment(3) }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formData" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" id="formAppend">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="formSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 2-->
    <div class="modal fade" id="trainerpayment" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize" id="exampleModalLabel ">Form: Trainer Payment </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="trainerp" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" id="trainerpay">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="trainerpaymentSubmit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dt-responsive table-responsive">
                        <table id="list-table"
                            class="table table-hover table-bordered table-sm dt-responsive nowrap my-0 card-outline card-primary"
                            style="width: 100%">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('backend.layouts.datatable-link')
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            fill_datatable();

            function fill_datatable() {
                var dataTable = $('#list-table').DataTable({
                    "searching": true,
                    "processing": true,
                    "lengthChange": true,
                    "lengthMenu": [10, 25, 50, 75, 100],
                    dom: '<"class"B><"d-flex justify-content-between mt-2"lf>tipr',
                    "language": {
                        processing: 'Please Wait...',
                        searchPlaceholder: "Search here"
                    },
                    "serverSide": true,
                    "keys": true,
                    "pagingType": "full_numbers",
                    "ajax": {
                        "url": "{{ route('admin.trainer.show', 'dataTable') }}",
                        "dataType": "json",
                        "type": "GET",
                        "data": {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            data: {}
                        }
                    },
                    "columns": [{
                            data: 'id',
                            title: 'S.N',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'name',
                            title: 'Name',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'phone',
                            title: 'Phone',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'address',
                            title: 'Address',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'role',
                            title: 'Role',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'created_at',
                            title: 'Created Date',
                            orderable: true,
                            searchable: false
                        },
                        {
                            data: 'payment',
                            title: 'Payment',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            title: 'Action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    "row": [],
                    "order": [
                        [0, "desc"]
                    ]
                });

                $('#list-table').on('draw.dt', function() {
                    $('[data-toggle="tooltip"]').tooltip();
                    $('#list-table_paginate').addClass("pagination-sm");
                    $('#list-table_info').addClass("float-left p-0 my-auto");
                });

                {{-- Trainer Payment --}}

                $('#list-table tbody').on('click', '.modalbtn, .delete-confirm', function(event) {
                    event.preventDefault();
                    var formOf = $(this).attr('data-type');
                    if (formOf === 'edit') {
                        var url = $(this).attr('data-url');
                        modalAppend(url);
                    }
                    if (formOf === 'trainerpayment') {
                        var url = $(this).attr('data-url');
                        modalAppend(url);

                    }
                    if (formOf === 'delete_trainer') {
                        const url = $(this).attr('action');
                        delete_trainer(url, dataTable);
                    }
                });

                $('#formData').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    var name = $('#name').val();
                    var address = $('#address').val();
                    var phone = $('#phone').val();
                    var payment = $('#payment').val();
                    var shift_id = $('#shift_id').val();
                    var join_date = $('#join_date').val();

                    if (name == "") {
                        $('#error_name').html('Name is Required !');
                    } else if (address == "") {
                        $('#error_address').html('Address is Required !');

                    } else if (phone == "") {
                        $('#error_phone').html('Phone Number is Required !');
                    } else if (payment == "") {
                        $('#error_payment').html('Payment field  is Required !');
                    } else if (shift_id == "") {
                        $('#error_shift').html('shift is Required !');
                    } else if (join_date == "") {
                        $('#error_joindate').html('Joining date is Required !');
                    } else {
                        var formData = new FormData(this);
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('admin.trainer.store') }}",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: (data) => {
                                var type = data.atype,
                                    msg = data.message;
                                toastr[type](msg);
                                $('#myModal').modal('hide');
                                dataTable.ajax.reload();

                                $('#payment').modal('hide');
                                dataTable.ajax.reload();
                            },
                            error: function(data) {
                                alert("Sorry! we cannot load data this time");
                                return false;
                            }
                        });
                    }
                });


                $('#trainerp').submit(function(e) {
                    e.preventDefault();

                    var trainerp = new FormData(this);
                    var tpay = $('#trainerpay');
                    var month = tpay.find('#month').val();
                    var shift = tpay.find('#no_shift').val();
                    var rate = tpay.find('#rate').val();
                    var presentday = tpay.find('#presentday').val();
                    var amount = tpay.find('#amount').val();
                    var advance = tpay.find('#advance').val();
                    var net_amount = tpay.find('#net_amount').val();



                    if (month == "") {

                        tpay.find('#error_month').html('Month Field is required !');

                    } else if (presentday == "") {
                        tpay.find('#error_presentday').html('Present Day Field is required !');
                    } else if (rate == "") {
                        tpay.find('#error_rate').html('Rate Field is required !');
                    } else if (shift == '') {
                        tpay.find('#error_shift').html('Shift Field is required !');

                    } else {
                        var formData = new FormData(this);
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('admin.trainerpayment.store') }}",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: (data) => {
                                var type = data.atype,
                                    msg = data.message;
                                toastr[type](msg);
                                $('#trainerpayment').modal('hide');
                                dataTable.ajax.reload();
                            },
                            error: function(data) {
                                alert("Sorry! we cannot load data this time");
                                return false;
                            }
                        });
                    }

                });

            }
        });

        $('#modelBtn').on('click', function() {
            var url = "{{ route('admin.trainer.create') }}";
            modalAppend(url);
        });

        function result() {
            var tpay = $('#trainerpay');
            var shift = tpay.find('#no_shift').val();
            var rate = tpay.find('#rate').val();
            var net_amount = tpay.find('#net_amount').val();
            var mul = shift * rate;
            tpay.find('#amount').val(mul);
            tpay.find('#net_amount').val(mul);
        }
        function finalamount(){
            var tpay = $('#trainerpay');
            var advance = tpay.find('#advance').val();
            var mulamount =   tpay.find('#amount').val();
            var net_amount = mulamount - advance;
            console.log(net_amount);
            tpay.find('#net_amount').val(net_amount);
        }
    </script>

@endpush

