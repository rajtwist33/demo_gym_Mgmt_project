@extends('superadminbackend.components.app')
@push('style')
@endpush
@section('content')
<section class="content-header p-0">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <button type="button" id="modelBtn" class="btn btn-primary text-capitalize" data-toggle="modal" data-target="#myModal">
          + {{ Request::segment(3) }}
        </button>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('superadmin.home') }}">Home</a></li>
          <li class="breadcrumb-item text-capitalize active">{{ Request::segment(3) }}</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel ">Creating  {{ Request::segment(3) }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formData">
        <div class="modal-body" id="formAppend">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="formSubmit">Submit</button>
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

@include('superadminbackend.components.datatable-link')

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
            "url": "{{route('superadmin.offer.show','dataTable')}}",
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
          { data: 'status',title: 'Status', orderable: true,searchable: true},
          { data: 'created_at',title: 'Created AT', orderable: true,searchable: true},
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

      {{-- store --}}
      $('#formSubmit').on('click', function(){
         var datastring = $("#formData").serializeArray(),
         url = "{{ route('superadmin.offer.store') }}";
        store(url, datastring, dataTable);

      });

      $('#list-table tbody').on('click','.modalbtn, .delete-confirm', function(event){
        event.preventDefault();
        var formOf = $(this).attr('data-type');
        if (formOf === 'edit') {
          var url = $(this).attr('data-url');
          modalAppend(url);
        }

        if(formOf === 'destroy') {
          const url = $(this).attr('action');
          destroy(url, dataTable);
        }
      });
    }
});

$('#modelBtn').on('click', function(){
  var url = "{{ route('superadmin.offer.create') }}";
  modalAppend(url);
});
</script>
@endpush
