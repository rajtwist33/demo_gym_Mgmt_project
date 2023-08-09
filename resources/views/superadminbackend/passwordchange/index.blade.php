@extends('superadminbackend.components.app')
@push('style')

@endpush
@section('content')
<section class="content-header p-0">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
      <h4>SuperAdmin  Change Password</h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('superadmin.home') }}">Home</a></li>
          <li class="breadcrumb-item text-capitalize active">{{ Request::segment(2) }}</li>
        </ol>
      </div>
    </div>
  </div>
</section>


<section class="content mt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
              @if($errors->any())
              <div id="errorhide" class="alert alert-danger">
                  <p><strong>Opps Something went wrong</strong></p>
                  <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                  </ul>
                </div>
              @endif
              @if(Session::has('success'))
                <p id="success" class="alert alert-info">{{ Session('success') }}</p>
                @endif
            <div class="card">
              <div class="card-body">
               <form action="{{route('superadmin.change_password.store')}}" method="post">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Name</label>
                        <input type="text" name="name" class="form-control" value="{{$data->name}}" id="exampleInputPassword1">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" name="email" class="form-control" value="{{$data->email}}" id="exampleInputPassword1">
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Current Password</label>
                        <input type="text" name="current_pass" class="form-control" value="{{old('current_pass')}}" id="exampleInputPassword1" placeholder="Enter a Current Password">
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="text" name="new_pass" class="form-control" value="{{old('new_pass')}}" id="exampleInputPassword1" placeholder="Enter a New Password">
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Conform Password</label>
                        <input type="text" name="conf_pass" class="form-control" value="{{old('conf_pass')}}" id="exampleInputPassword1" placeholder="Enter  Again Password">
                      </div>
                  </div>
                  <input type="hidden" name="data_id" class="form-control" value="{{$data->id}}" id="exampleInputPassword1">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
               </form>
              </div>
            </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('script')
    <script>
        setTimeout(function() {
     $('#errorhide').hide(); 
      },8000);
        setTimeout(function() {
          $('#success').hide(); 
      },4000);
    </script>
@endpush