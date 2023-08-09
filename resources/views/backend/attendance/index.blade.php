@extends('backend.layouts.app')
@push('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
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
          <div class="row">
            <div class="col-3">
              <div class="form-group ">
                <label for="shift-select">Work Out Shift</label>
                <select class="custom-select" name="shift" id="shift-select" value="{!! $data_list->shift ?? old('shift') !!}" >
                  <option value=""> -- Choose WorkOut Shift -- </option>
                  @foreach($shifts as $shift)
                  <option value="{{ $shift->id }}"  >{{ $shift->shift_name }} <span>(</span> <span>{{ date('g:i a', strtotime($shift->starttime)) }}</span><span> - </span> <span>{{ date('g:i a', strtotime($shift->endtime)) }}</span> <span>)</span></option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-4" style="margin:0.7%;">
                <div class="form-group input-group mt-4" >
                    <div class="input-group-prepend">
                      <div class="input-group-text">Attendance Date </div>
                    </div>
                     <input type="date" class="form-control" id="date-select" name="date"  value="{!! $data_list->date ?? date('Y-m-d') !!}" autocomplete="off" max="{{ date('Y-m-d') }}">
                </div>
            </div>

          </div>
        <div class="dt-responsive table-responsive">
          <table id="list-table" class="table table-hover table-bordered table-sm dt-responsive nowrap my-0  card-outline card-primary" style="width: 100%">
            <thead class="thead-dark">
              <tr class="text-center">
              </tr>
            </thead>
            <tbody id="formData"></tbody>
          </table>
        </div>
      </div>
      <button type="button" class="btn btn-sm btn-primary col-md-2 float-center" id="formSubmit" data-type="attendence" data-url="{{ route('admin.attendance.store') }}">Submit</button>
    </div>
  </div>
</section>
@endsection
@include('backend.layouts.datatable-link')
@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    fill_datatable();

    $('#shift-select').on('change', function(){
      var shift_data = $(this).children("option:selected").val();
      $('#list-table').DataTable().destroy();
      fill_datatable(shift_data);

    });

    function fill_datatable(shift_data ='' )
    {
      var data_s= shift_data;
      var dataTable = $('#list-table').DataTable({
        "searching" : false,
        "processing": true,
        "lengthChange": true,
        "bInfo": false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
    "paging": false,//Dont want paging
    "bPaginate": false,//Dont want paging
        "lengthMenu": [ 10, 25, 50, 75, 100 ],
        dom: '<"class"B><"d-flex justify-content-between mt-2"lf>tipr',
        "language": {
            processing: 'Please Wait...',
            searchPlaceholder: "Search name"
        },
        "serverSide": true,
        "keys": true,
        "pagingType": "full_numbers",
        "ajax":{
            "url": "{{route('admin.attendance.show','dataTable')}}",
            "dataType": "json",
            "type": "GET",
            "data":{
                _token : $('meta[name="csrf-token"]').attr('content'),
                data_s : data_s,
                // data_d : data_d,

            }
        },
        "columns": [
          { data: 'shift_name',title: 'Shift', orderable: true,searchable: false},
          { data: 'name',title: ' Name', orderable: true,searchable: true},
          { data: 'action', title: 'Attendance',orderable: false, searchable: false },
          { data: 'remark', title: 'Remark',orderable: false, searchable: false },

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

      $('#list-table tbody').on('click','.addSwitch, .delete-confirm', function(event){
        event.preventDefault();
        var formOf = $(this).attr('data-type');
        if (formOf === 'attendance') {
          var url = $(this).attr('data-url');
          modalAppend(url);
        }
      });
    }
});


$('#formSubmit').on('click', function(){
  var datastring = $('.attend').serializeArray(),
      dataVal = $('.dataval').serializeArray(),
      remark = $('.remark').serializeArray(),
      s_shift = $('.shiftval').serializeArray(),
      s_date = $('#date-select').val(),
      url = "{{ route('admin.attendance.store') }}";

  storeAttend(url, datastring, dataVal, remark, s_shift, s_date);
});

$(document).on('change', '.attendance', function() {
      // console.log(this.checked);
    let data_of = $(this).attr('data-of');
    if(this.checked) {
      $('.attendance_val'+data_of).val('1');
    }else{
      $('.attendance_val'+data_of).val('0');
    }
});
</script>

@endpush
