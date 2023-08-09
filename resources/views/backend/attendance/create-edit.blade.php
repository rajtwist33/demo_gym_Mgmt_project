
<div class="row">
    <div class="col-3">
      <div class="form-group">
        <label for="shift">Work Out Shift</label>
        <select class="custom-select" name="shift"   id="shift" value="{!! $data_list->shift ?? old('shift') !!}" >
          <option value=""> -- Choose WorkOut Shift -- </option>
          @foreach($shifts as $shift)
          <option value="{{ $shift->id }}"  >{{ $shift->shift_name }} <span>(</span> <span>{{ date('g:i a', strtotime($shift->starttime)) }}</span><span> - </span> <span>{{ date('g:i a', strtotime($shift->endtime)) }}</span> <span>)</span></option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-4">
      <label for="shift">Date</label>
      <div class="form-group">
        <input type="input" class="form-control text-danger" value="{{ $dates }}" disabled>
      
      </div>
    </div>
  </div>
1
  <div class="row">
    <div class="col-12">
      <table class="table" border='1' id="table">
        <thead>
          <tr>
           
            <th scope="col">Name</th>
            <th scope="col ">Attendance</th>
            <th scope="col">Remark</th>
          </tr>
        </thead>
        <tbody id="tbody">
          @foreach ($datas as $data )    
          <tr>
            {{-- <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $data['users']->name }}</td>
            <td>a</td>
            <td><input type="text" class="form-control" value=""></td> --}}
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

 <script type="text/javascript">
    $(document).ready(function(){
        $("#shift").on('change',function(){
          var shift = $(this).val();
            $.ajax({
                url: "{{ route('admin.userattendance.index') }}",
                type: 'GET',
                data:{'shift':shift},
                success: function(data) {                 
                  var filter = data.datas;
                  var html = '';                
                  if(filter.length > 0){
                    for(let i=0; i<filter.length; i++)                  
                    {
                      html +='<tr>\
                        <td>'+filter[i]['users']['name']+'</td>\
                        <td>\
                          <div class="custom-control custom-switch text-center">\
                            <input type="checkbox" class="custom-control-input " name="status[]" id="customSwitch1">\
                            <label class="custom-control-label " for="customSwitch1"></label>\
                          </div>\
                        </td>\
                         <td><input type="text" class="form-control" name="remark" ></td>\
                        </tr>';
                    }
                  }
                  else {
                      html +='<tr>\
                        <td>No Records Found</td>\
                        </tr>';
                  }
                   $("#tbody").html(html);
                }
            });
        });
      });
</script>
