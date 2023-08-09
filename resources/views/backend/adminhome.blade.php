@extends('backend.layouts.app')

@section('content')
<div class="row mb-2">
    <div class="col-sm-6">
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
        <li class="mr-2"></li>
      </ol>
    </div>
  </div>
  <div class="container">
<div class="row mt-3">

    <div class="col-md-3">
    <a href="{{ route('admin.gymer.index')}}">
      <div class="card">
        <div class="card-body">
        <span><i class="fas fa-users nav-icon"></i></span> <span class="fs-3">Active Gymer</span>
        <h3 class="text-center">{{$active_gymer}}</label>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="#">
      <div class="card">
        <div class="card-body" style="cursor:not-allowed;">
        <span><i class="fas fa-user-slash nav-icon"></i></span> <span class="fs-3"> Inactive Gymer</span>
        <h3 class="text-center">{{$inactive_gymer}}</label>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="{{route('admin.trainer.index')}}">
      <div class="card">
        <div class="card-body">
        <span><i class="fas fa-users nav-icon"></i></span><span>Trainer</span>
        <h3 class="text-center">{{$trainer}}</label>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="#">
      <div class="card">
        <div class="card-body" style="cursor:not-allowed;">
        <span><i class="far fa-money-bill-alt"></i></span> <span>Total Amount </span>
        <h3 class="text-center ">Rs.{{$total_amount}}</label>
      </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="{{ route('admin.offers.index') }}">
      <div class="card">
        <div class="card-body">
          <span><i class="fas fa-gift nav-icon mr-2"></i></span><span>Offer</span>
          <h3 class="text-center">{{$offer}}</label>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="{{route('admin.anual_paymenttype.index')}}">
      <div class="card">
        <div class="card-body">
          <span><i class="fas fa-money-check-alt nav-icon mr-2"></i></span><span>Payment Type</span>
          <h3 class="text-center">{{$anual_payment}}</label>
        </div>
      </div>
      </a>
    </div>
</div>
</div>

@endsection
