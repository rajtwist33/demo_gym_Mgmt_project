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
    <div class="col-md-6 mb-2">
        <a href="{{ route('admin.trainer.index') }}" class=" btn btn-secondary"> <i class="fas fa-arrow-left">
            </i></a><br><br>
    </div>

    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong for="" class="m-4">Trainer Name: </strong> <span
                                    class="m-3">{{ $demo->users->name }}
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong for="" class="m-4">Trainer Phone: </strong> <span
                                    class="m-3">{{ $demo->phone }} </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong for="" class="m-4">Trainer Address: </strong> <span
                                    class="m-3">{{ $demo->address }} </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong for="" class="m-4">Shift : </strong>
                                @if (count($trainershifts) > 0)
                                    <ol>
                                        @foreach ($trainershifts as $trainershift)
                                            <li>{{ $trainershift->shifts->shift_name }} <span>(
                                                    {{ $trainershift->shifts->starttime }} -</span>
                                                <span>{{ $trainershift->shifts->endtime }})</span>
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                    @include('backend.trainer.modal')
                    @if (!$old_amount)
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal"
                            data-toggle="tooltip" data-placement="top" title="Add previous amount before 2023/july">
                            Add Previous Amount
                        </button>
                    @endif
                    @if ($old_amount)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Previous Payment History <small class="text-danger">(Amount Before
                                        2023/July)</small></h3>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="">#</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Created Date</th>
                                            @if($count_payment < 2)
                                                <th scope="col">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($old_amount)
                                            <tr>
                                                <td> 1</td>
                                                <td>Rs. {{ $old_amount->net_amount }}</td>
                                                <td>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="1">{{ $old_amount->description }}
                                                </textarea>
                                                </td>
                                                <td> <span class="text-success mr-2">
                                                        {{ date('Y-M-d', strtotime($old_amount->created_at)) }}</span><br>
                                                    ({{ $old_amount->created_at->diffForHumans() }})</td>
  @if($count_payment < 2)
                                                <td>
                                                    <div class="row justify-content-evenly">
                                                        <form
                                                            action="{{ route('admin.trainerpayment.destroy', $old_amount->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button class="btn btn-danger btn-sm m-1"
                                                                onclick="return confirm('Are you sure to delete?')">Delete</button>
                                                        </form>

                                                    </div>
                                                </td>
@endif
                                            </tr>
                                        @else
                                            <td colspan="12">
                                                <p class="text-center text-bold"> No Any Record Availble.</p>
                                            </td>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <hr>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Current Payment History <small class="text-danger">(Amount After
                                    2023/July)</small></h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="">#</th>
                                        <th scope="col">Paid Month</th>
                                        <th scope="col">Present</th>
                                        <th scope="col">Total Shift</th>
                                        <th scope="col">Advance Cleared</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Created Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($datas) > 0)
                                        @foreach ($datas as $key => $data)
                                            <tr>
                                                <td> {{ $loop->iteration }}</td>
                                                <td> <b class="text-primary">
                                                        {{ \Carbon\Carbon::parse($data->month)->format('M/Y') }}</b><br>
                                                    <b class="text-danger">{{ $key == 0 ? '(new)' : '' }} </b>
                                                </td>
                                                <td> <span class="text-bold">{{ $data->present }} </span>days</td>
                                                <td><span class="text-bold">{{ $data->no_shift }}</span> shifts</td>
                                                <td>{{ $data->advance }}</td>
                                                <td>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="1">{{ $data->description }}
                                                      </textarea>
                                                </td>
                                                <td>Rs. {{ $data->net_amount }}</td>
                                                <td> <span class="text-success mr-2">
                                                        {{ date('Y-M-d', strtotime($data->created_at)) }}</span><br>
                                                    ({{ $data->created_at->diffForHumans() }})
                                                </td>
                                                <td>
                                                    <div class="row justify-content-evenly">

                                                        <form
                                                            action="{{ route('admin.trainerpayment.destroy', $data->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            {{-- <input type="hidden" value="{{ $data->id }}"
                                                                    name="data_id"> --}}
                                                            <button class="btn btn-danger btn-sm m-1"
                                                                onclick="return confirm('Are you sure to delete?')">Delete</button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="6" class="text-center"> <strong class="text-danger"> Total
                                                    Amount </strong></td>
                                            <td colspan="3"><strong> Rs. {{ $total_amount }} </strong></td>
                                        </tr>
                                    @else
                                        <td colspan="12">
                                            <p class="text-center text-bold"> No Any Record Availble.</p>
                                        </td>
                                    @endif

                                </tbody>
                            </table>
                            {{ $datas->links() }}
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
        </script>
    @endpush
