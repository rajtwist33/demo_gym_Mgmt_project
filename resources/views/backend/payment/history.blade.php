@extends('backend.layouts.app')
@push('style')
@endpush
@section('content')
    <section class="content-header p-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-3">
                    <strong class="text-info  text-capitalize" style="font-size: 30px;">
                        Payment History
                    </strong>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item text-capitalize active">Payment-history</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="col-md-6">
        <a href="{{ route('admin.gymer.index') }}" class=" btn btn-secondary"> <i class="fas fa-arrow-left">
            </i></a><br><br>
    </div>

    <div class="container">
        <div class="row ">
            <div class="col-md-4">
                <strong>Name : </strong> <label for="" class="ml-2">{{ $details['0']->users->name }}</label><br>
                <strong>Address : </strong> <label for="" class="ml-2">{{ $details['0']->address }}</label><br>
                <strong>Admission Fee : </strong> <label for="" class="ml-2">
                    {{ $details['0']->admission }}</label><br>
                <strong>Phone : </strong> <label for="" class="ml-2">{{ $details['0']->phone }}</label><br>
                <strong>shift : </strong> <label for=""
                    class="ml-2">{{ $details['0']->shifts->shift_name }}</label>
                (<label for="" class="ml-2">{{ $details['0']->shifts->starttime }}</label> - <label for=""
                    class="ml-2">{{ $details['0']->shifts->endtime }} </label> )

            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payment Types</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="">#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Payment Type</th>
                                        <th scope="col">Paid Amount</th>
                                        <th scope="col">Month Left</th>
                                        <th scope="col">Days Left</th>
                                        <th scope="col">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $now = Carbon\Carbon::now(); ?>

                                    @foreach ($payment_type as $payment)
                                        <?php $month_count = Carbon\Carbon::parse($payment->end_date)->diffInMonths($now);
                                        $days_count = Carbon\Carbon::parse($payment->end_date)->diffInDays($now); ?>
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('Y-M-d', strtotime($payment->start_date)) }}</td>
                                            <td>{{ $payment->anual_payment->payment_name }}</td>
                                            <td>{{ $payment->anual_payment->total_amount }}</td>
                                            <td>{{ $month_count !== 0 ? $month_count + 1 : '' }}</td>
                                            <td>{{ $month_count == 0 ? $days_count : '' }}</td>
                                            <td>{{ $payment->is_active == 1 ? 'Active' : 'Expired' }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <hr>
                @include('backend.payment.modal')
                @if (!$old_amount)
                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal"
                        data-toggle="tooltip" data-placement="top" title="Add previous amount before 2023/july">
                        Add Previous Amount
                    </button>
                @endif
                @if ($old_amount)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title ">Previous Payment History <small class="text-danger">(Before 2023/July
                                    )</small></h3>
                        </div>
                        <div class="col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="">#</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Paid Amount</th>
                                                <th scope="col">Desciption</th>
                                                @if ($count_currenttransaction < 2)
                                                    <th scope="col">Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>

                                                <td>{{ date('Y-M-d', strtotime($old_amount->date)) }} </td>

                                                <td>{{ $old_amount->amount }}</td>
                                                <td>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="1">{{ $old_amount->description }}</textarea>
                                                </td>
                                                @if ($count_currenttransaction < 2)
                                                <td>
                                                <form action="{{ route('admin.payment_history.edit', $old_amount->id) }}"
                                                    method="get">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger undo_payment float-left"
                                                        data-toggle="tooltip" title='Undo Payment'> <i
                                                            class="fa fa-redo"></i> </button>
                                                </form>
                                             </td>
                                    @endif
                              </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    @endif
    <hr>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Current Payment History <small class="text-danger">(After 2023/July )</small>
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Paid Amount</th>
                            <th scope="col">Dues</th>
                            <th scope="col">Advance</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($payments as $key => $payment)
                            <tr>
                                <td>{{ $loop->iteration }} </td>

                                <td>{{ date('Y-M-d', strtotime($payment->date)) }} </td>

                                <td>{{ $payment->amount }}</td>
                                <td>{{ abs($payment->dues) }}</td>
                                <td>{{ $payment->advance }}</td>
                                @if ($key == 0)
                                    <td>
                                        <form action="{{ route('admin.payment_history.edit', $payment->id) }}"
                                            method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger undo_payment float-left"
                                                data-toggle="tooltip" title='Undo Payment'> <i class="fa fa-redo"></i>
                                            </button>
                                        </form>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                        <td colspan="2" class="text-center text-dark"> <strong>Total Amount</strong> </td>
                        <td colspan="4"><strong>Rs. {{ $total_amount }}</strong> </td>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

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
        $('.undo_payment').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to Undo this record?`,
                    text: "If you Undo this, it will be gone forever.",
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
@endpush
