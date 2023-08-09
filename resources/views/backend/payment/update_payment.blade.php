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
       Edit Payment  
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
    <a href="{{ route('admin.gymer.index') }}" class=" btn btn-secondary">Back</a><br><br>
  </div>
 
<div class="container">
    <div class="row ">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <strong>Name : </strong> <label for="" class="ml-2">{{$details['0']->users->name}}</label><br>
                    <strong>Address : </strong> <label for="" class="ml-2">{{$details['0']->address}}</label><br>
                    <strong>Phone : </strong> <label for="" class="ml-2">{{$details['0']->phone}}</label><br>
                    <strong>shift : </strong> <label for="" class="ml-2">{{$details['0']->shifts->shift_name}}</label>
                                    (<label for="" class="ml-2">{{$details['0']->shifts->starttime}}</label> - <label for="" class="ml-2">{{$details['0']->shifts->endtime}} </label> )
                 </div>
             </div>  
             </div>
        <div class="col-md-6">
        <div class="card">
            <div class="card-body">
            <form action="{{route('admin.payment_history.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="date" name="date" value="{{$edit_payment['0']->date}}" class="form-control"  aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Amount</label>
                    <input type="number" value="{{$edit_payment['0']->amount}}" name="amount" class="form-control" min="0" oninput="validity.valid||(value='');" aria-describedby="emailHelp">
                    <input type="hidden" value="{{$edit_payment['0']->id}}" name="data_id" class="form-control"  aria-describedby="emailHelp">
                    <input type="hidden" value="{{$edit_payment['0']->user_id}}" name="user_id" class="form-control"  aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Advance</label>
                    <input type="number" value="{{$edit_payment['0']->advance}}" name="advance" class="form-control" min="0" oninput="validity.valid||(value='');" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Dues</label>
                    <input type="number" value="{{$edit_payment['0']->dues}}" name="dues" class="form-control"min="0" oninput="validity.valid||(value='');"  aria-describedby="emailHelp">
                </div>
                 <button type="submit" class="btn btn-primary">Update Payment</button>
            </form>
            </div>
        </div>
        </div> 
    </div>
</div>

@endsection
@push('script')

@endpush