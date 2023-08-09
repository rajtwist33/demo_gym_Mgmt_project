@extends('superadminbackend.components.app')
@push('style')
@endpush
@section('content')
<section class="content-header p-0">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <button type="button" id="modelBtn" class="btn btn-primary text-capitalize" data-toggle="modal" data-target="#myModal" data-type="store">
          + Blood Type
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
<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel "><b>Form : </b> {{ Request::segment(3) }}</h5>
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
          <table id="list-purchase-table" class="table table-hover table-bordered table-sm dt-responsive nowrap my-0  card-outline card-primary" style="width: 100%">
            <thead class="thead-dark">
              <tr class="text-center">
                <th width="4%">S.N</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Action</th>
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
      var dataTable = $('#list-purchase-table').DataTable({
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
            "url": "{{route('superadmin.blood_type.show','dataTable')}}",
            "dataType": "json",
            "type": "GET",
            "data":{
                _token: $('meta[name="csrf-token"]').attr('content'),
                data:{
                    // 'product' : form1,
                }
            }
        },
        "columns": [
            { data: 'id',title: 'S.N', orderable: true,searchable: true},
            { data: 'name',title: 'Name', orderable: true,searchable: true},
            { data: 'created_at', title: 'Created Date',orderable: true, searchable: false },
            { data: 'action', title: 'Action',orderable: false, searchable: false },
        ],
        "row": [],
        "order": [
          [ 0 ,"desc" ]
        ]
      });

      $('#list-purchase-table').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#list-purchase-table_paginate').addClass("pagination-sm");
        $('#list-purchase-table_info').addClass("float-left p-0 my-auto");
      });

      {{-- store --}}
      $('#formSubmit').on('click', function(){
        var datastring = $("#formData").serializeArray(),
            url = "{{ route('superadmin.blood_type.store') }}";
        store(url, datastring, dataTable);
      });

      $('#list-purchase-table tbody').on('click','.modalbtn, .delete-confirm', function(event){
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
  var formOf = $('#modelBtn').attr('data-type');
  if (formOf == 'store') {
    var url = "{{ route('superadmin.blood_type.create') }}";
    modalAppend(url);
  }
});
</script>
@endpush
