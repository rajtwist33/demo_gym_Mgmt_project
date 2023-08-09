@extends('backend.layouts.app')
@push('style')
@endpush
@section('content')
<section class="content-header p-0">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">

      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
          <li class="breadcrumb-item text-capitalize active mr-1 ml-1">Pdf</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content mt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
       <div class="card">
        <div class="card-body">
           <label class="fs-1">Print Gymer Dues </label>
           <br>
            <form action="{{route('admin.search.gymerdues')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Choose Shift</label>
                    </div>
                    <select class="custom-select" placeholder="Select a Shift" id="inputGroupSelect01" name="shift" required>
                        <option value="">Select Shift</option>
                         @foreach ($shifts as $shift )

                                <option value="{{$shift->id}}">{{$shift->shift_name}} (<span class="ml-1">{{$shift->starttime}}</span> <strong> - </strong>  <span class="ml-1">{{$shift->endtime}}</span>) </option>
                        @endforeach

                    </select>
                    <button type="submit" class="btn btn-primary"> <i class="bi bi-printer"></i>Print</button>
                </div>
            </form>
        </div>
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
            "url": "{{route('admin.profile','dataTable')}}",
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
          { data: 'role',title: 'Role', orderable: true,searchable: true},
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


      $('#list-table tbody').on('click','.print_profile', function(event){
        event.preventDefault();
        var formOf = $(this).attr('data-type');

        if (formOf === 'print_profile') {
          var url = $(this).attr('data-url');
          modalAppend(url);
        }

      });

    }

});

</script>

@endpush
