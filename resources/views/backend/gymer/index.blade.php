@extends('backend.layouts.app')
@push('style')
@endpush
@section('content')
<section class="content-header p-0">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <button type="button" id="modelBtn" class="btn btn-primary text-capitalize" data-toggle="modal" data-target="#myModal">
          + Gymer
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

<!-- Modal 1-->
<div class="modal fade" id="myModal"  data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered  modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel ">Form: {{ Request::segment(3) }}</h5>
      @if(count($offer_alerts) > 0)
          <span class="ml-5 text-danger fs-1 "> Offer Alert : </span>
        @foreach ($offer_alerts as $offer_alert)
                <span class="text-primary ml-2"> {{$offer_alert->name}} </span><span>,</span>
       @endforeach

       @endif
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  id="formData" method="POST" enctype="multipart/form-data">
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
<div class="modal fade" id="payment" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel ">Form: Payment </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="paymentdata">
        <div class="modal-body" id="paymentform">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button"  class="btn btn-primary" id="paymentSubmit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal 3-->
<div class="modal fade" id="users-profile" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel ">Form: Users-Profile </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="profile" enctype="multipart/form-data">
        <div class="modal-body" id="users_profile">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button"  class="btn btn-primary" id="users_profilesubmit">Submit</button>
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
          <table id="list-table" class="table table-hover table-bordered table-sm dt-responsive nowrap my-0  card-outline card-primary" style="width: 100%">
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
  $(document).ready(function(){
    fill_datatable();
    function fill_datatable()
    {
      var dataTable = $('#list-table').DataTable({
        "searching" : true,
        "processing": true,
        "lengthChange": true,
        "lengthMenu": [ 10, 25, 50, 75, 100 ,200],
        dom: '<"class"B><"d-flex justify-content-between mt-2"lf>tipr',
        "language": {
            processing: 'Please Wait...',
            searchPlaceholder: "Search here"
        },
        "serverSide": true,
        "keys": true,
        "pagingType": "full_numbers",
        "ajax":{
            "url": "{{route('admin.gymer.show','dataTable')}}",
            "dataType": "json",
            "type": "GET",
            "data":{
                _token: $('meta[name="csrf-token"]').attr('content'),
                data:{

                }
            }
        },
        "columns": [
          { data: 'id',title: 'S.N', orderable: true,searchable: true},
          { data: 'name',title: 'Name', orderable: true,searchable: true},
          { data: 'phone',title: 'Phone', orderable: true,searchable: true},
          { data: 'address',title: 'Address', orderable: true,searchable: true},
          // { data: 'role',title: 'Role', orderable: true,searchable: true},
          { data: 'created_at', title: 'Created Date',orderable: true, searchable: false },
          { data: 'payment', title: 'Payment',orderable: true, searchable: false },
          { data: 'action', title: 'Action',orderable: false, searchable: false },
        ],
        "row": [],
        "order": [
          [ 0 ,"desc" ]
        ]
      });
      $('#list-table').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#list-table_paginate').addClass("pagination-sm");
        $('#list-table_info').addClass("float-left p-0 my-auto");
      });

      {{-- payment --}}
      $('#paymentSubmit').on('click', function(){
        var datastring = $("#paymentdata").serializeArray(),
            url = "{{ route('admin.payment.store') }}";
        store(url, datastring, dataTable);
      });

      {{-- profile --}}
      $('#users_profilesubmit').on('click', function(){
        var datastring = $("#profile").serializeArray(),
            url = "{{ route('admin.users_profile.store') }}";
        store(url, datastring, dataTable);
      });

      $('#list-table tbody').on('click','.modalbtn, .delete-confirm', function(event){
        event.preventDefault();
        var formOf = $(this).attr('data-type');
        if (formOf === 'edit') {
          var url = $(this).attr('data-url');
          modalAppend(url);
        }
        if (formOf === 'payment') {

          var url = $(this).attr('data-url');
          modalAppend(url);
        }
        if(formOf === 'destroy') {
          const url = $(this).attr('action');
          destroy(url, dataTable);
        }
        if(formOf === 'users_profile') {
          const url = $(this).attr('data-url');
          modalAppend(url);
        }
      });

      $('#formData').submit(function(e) {
      e.preventDefault();
          var formData = new FormData(this);
          var name = $('#name').val();
          var address = $('#address').val();
          var phone = $('#phone').val();
          var fee = $('#fee').val();
          var shift_id = $('#shift_id').val();
          var join_date = $('#join_date').val();

          if ( name == "" ) {
             $('#error_name').html('Name is Required !');
          }

          else if ( address == "" ) {
            $('#error_address').html('Address is Required !');

          }
          else if ( phone == "" ) {
             $('#error_phone').html('Phone Number is Required !');
          }
          else if ( fee == "" ) {
             $('#error_fee').html('fee  is Required !');
          }
          else if ( shift_id == "" ) {
             $('#error_shift').html('shift is Required !');
          }

          else if ( join_date == "" ) {
             $('#error_joindate').html('Joining date is Required !');
          }

          else {
      $.ajax({
            type:'POST',
            url: "{{ route('admin.gymer.store') }}",
            data: formData,
            cache:false,
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
            error:function(data){
                alert("Sorry! we cannot load data this time");
                return false;
              }
            });
             }
        });
    }

});
$('#modelBtn').on('click', function(){
  var url = "{{ route('admin.gymer.create') }}";
  modalAppend(url);
});

</script>

@endpush
