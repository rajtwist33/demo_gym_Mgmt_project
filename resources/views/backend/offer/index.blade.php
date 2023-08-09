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
        "lengthMenu": [ 10, 25, 50, 75, 100 ],
        dom: '<"class"B><"d-flex justify-content-between mt-2"lf>tipr',
        "language": {
            processing: 'Please Wait...',
            searchPlaceholder: "Search here"
        },
        "serverSide": true,
        "keys": true,
        "pagingType": "full_numbers",
        "ajax":{
            "url": "{{route('admin.offers.show','dataTable')}}",
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
          { data: 'discount',title: 'Discount percent ', orderable: true,searchable: true},
          { data: 'start_date',title: 'Start Date', orderable: true,searchable: true},
          { data: 'end_date',title: 'End Date', orderable: true,searchable: true},

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




    }
});

</script>
@endpush
