@extends('backend.layouts.app')
@push('style')
@endpush
@section('content')
    <section class="content-header p-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <label class=" text-capitalize" style="font-size: 30px;">
                        Trainer Profile
                    </label>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item text-capitalize active">Trainer Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="col-md-6">
        <a href="{{ route('admin.trainer.index') }}" class=" btn btn-secondary"><i class="fas fa-arrow-left"> </i></a><br><br>
    </div>
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong for="" class="m-4">Trainer Name: </strong> <span
                                    class="m-3">{{ $datas->name }}
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong for="" class="m-4">Trainer Phone: </strong> <span
                                    class="m-3">{{ $datas->getUserDetail->phone }}
                                </span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong for="" class="m-4">Trainer Address: </strong> <span
                                    class="m-3">{{ $datas->getUserDetail->address }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h2 class="text-success text-center"> Trainer Shift</h2>
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
                        <h4 class="text-center ">Add Shift to the Trainer</h4>
                        <form method="post" action="{{ route('admin.trainershift.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="input-group control-group increment">
                                
                                <select name="shift" class="form-control" required>
                                    <option value="">Select Shift</option>
                                    @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}"><span>{{ $shift->shift_name }} </span> ( <span>{{$shift->starttime}} - </span> <span>{{$shift->endtime}} )</span></option>
                                    @endforeach
                                </select>
                            </div>
                           <input type="hidden" value="{{$datas->id}}" name="trainer_id">
                            <center> <button class="btn btn-primary btn-sm m-2" type="submit">Sumbit</button></center>
                        </form>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="container">
                        <h3 class="text-center"> Shift Table</h3>
                       
                        </label><br>
                        <ul class="list-group">
                            @foreach ($trainershifts as $trainershifts)
                                <li class="list-group-item bg-dark text-light">
                                    <label class=""> <b class="mr-2"> Shift:</b>
                                        {{ $trainershifts['shifts']->shift_name }} <span>(  {{ $trainershifts['shifts']->starttime }} - </span><span> {{ $trainershifts['shifts']->endtime }} )</span> </label>
                                         
                                        <a
                                            href="{{route('admin.trainershift.show',$trainershifts->id)}}"
                                            class="float-right  btn btn-danger btn-sm "
                                            onclick="return confirm('Are you sure?')"><i class="fas fa-trash "></i>
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
