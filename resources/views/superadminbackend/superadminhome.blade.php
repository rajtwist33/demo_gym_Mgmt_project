@extends('superadminbackend.components.app')
@section('content')
<div class="row mb-5">
  <div class="col-sm-6">
    <h1 class="m-0"></h1>
  </div>
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{route('superadmin.home')}}">Home</a></li>
      <li class="mr-2"></li>
    </ol>
  </div>
</div>
<div class="container">
<div class="row mt-3">
    <div class="col-md-3">
      <a href="{{ route('superadmin.users.index') }}">
      <div class="card">
        <div class="card-body">
        <span><i class="fas fa-user-cog mr-2 nav-icon"></i></span> <span class="fs-3">Admin</span>
        <h3 class="text-center">{{$admin}}</label>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="{{ route('superadmin.active_gymer.index')}}">
      <div class="card">
        <div class="card-body">
        <span><i class="fas fa-users mr-2 nav-icon"></i></span> <span class="fs-3">Active Gymer</span>
        <h3 class="text-center">{{$active_gymer}}</label>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="{{ route('superadmin.inactive_gymer.index') }}">
      <div class="card">
        <div class="card-body">
        <span><i class="fas fa-users-slash mr-2 nav-icon"></i></span> <span class="fs-3"> Inactive Gymer</span>
        <h3 class="text-center">{{$inactive_gymer}}</label>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="#">
      <div class="card">
        <div class="card-body">
        <span><i class="fas fa-users mr-2 nav-icon"></i></span><span>Trainer</span>
        <h3 class="text-center">{{$trainer}}</label>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="#">
      <div class="card">
        <div class="card-body">
        <span><i class="far fa-money-bill-alt mr-2"></i></span> <span>Total Amount </span>
        <h3 class="text-center ">Rs.{{$total_amount}}</label>
      </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="{{ route('superadmin.offer.index') }}">
      <div class="card">
        <div class="card-body">
          <span><i class="fas fa-gift mr-2 nav-icon"></i></span><span>Offer</span>
          <h3 class="text-center">{{$offer}}</label>
        </div>
      </div>
      </a>
    </div>
    <div class="col-md-3">
    <a href="{{ route('superadmin.shift.index') }}">
      <div class="card">
        <div class="card-body">
          <span><i class="fab fa-usps mr-2 nav-icon"></i></span><span>Shift</span>
          <h3 class="text-center">{{$shift}}</label>
        </div>
      </div>
      </a>
    </div>
</div>
</div>
@endsection

