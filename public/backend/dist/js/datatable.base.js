function store(url="", datastring="", dataTable="")
{
  $.ajax({
    type : "POST",
    dataType : "html",
    url : url,
    data:{
      _token : $('meta[name="csrf-token"]').attr('content'),
      datastring : datastring,
    },
    success:function(data){
      var data = JSON.parse(data),
          type = data.atype,
          msg = data.message;
      toastr[type](msg);

      $('#myModal').modal('hide');
      dataTable.ajax.reload();


      $('#payment').modal('hide');
      dataTable.ajax.reload();

      $('#trainerpayment').modal('hide');
      dataTable.ajax.reload();
    },
    error:function(data){
      alert("Sorry! we cannot load data this time");
      return false;
    }
  });

}

function storeAttend(url="", datastring="", dataVal="", remark="", s_shift="", s_date=""){
  $.ajax({
    type : "POST",
    dataType : "html",
    url : url,
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    data:{
      dataval : dataVal,
      datastring : datastring,
      remark : remark,
      s_shift : s_shift,
      s_date : s_date,

    },
    success:function(data){
      var data = JSON.parse(data),
          type = data.atype,
          msg = data.message;
      toastr[type](msg);
      location.reload();
    },
    error:function(data){
      alert("Sorry! we cannot load data this time");
      return false;
    }
  });
}

function modalAppend(url=""){
  $.ajax({
    type : "GET",
    dataType : "html",
    url : url,
    data:{
      _token: $('meta[name="csrf-token"]').attr('content'),
    },
    success:function(data){
      $("#formAppend").html();
      $("#formAppend").html(data);
      $("#paymentform").html();
      $("#paymentform").html(data);
      $("#users_profile").html();
      $("#users_profile").html(data);
      $("#trainerpay").html();
      $("#trainerpay").html(data);
    },
    error:function(data){
      alert("Sorry! we cannot load data this time");
      return false;
    }
  });
}


function destroy(url, dataTable){
  var token = $('meta[name="csrf-token"]').attr('content');
  swal({
    title: 'Are you sure?',
    text: 'This record and it`s details will be permanantly Inactive!',
    icon: 'warning',
    buttons: ["Cancel", "Yes!"],
    dangerMode: true,
    closeOnClickOutside: false,
  }).then(function(value) {
    if(value == true){
      $.ajax({
        url: url,
        type: "POST",
        data: {
          _token: token,
          '_method': 'DELETE',
        },
        success: function (data) {
          swal({
            title: "Success!",
            type: "success",
            text: data.message+"",
            icon: "success",
            timer: 3000,
            buttons: false,
            showConfirmButton: false,
          }).then(
            window.setTimeout(function(){
              dataTable.ajax.reload();
            } ,3000),
          );
          if (data.message.length == 2) {
            toastr.success(data.message[1]);
            toastr.error(data.message[0]);
          }
        },
        error: function (data) {
          swal({
            title: 'Opps...',
            text: data.message+"\n Please refresh your page",
            type: 'error',
            timer: '1500'
          });
        }
      });
    }else{
      swal({
        title: 'Cancel',
        text: "Data is safe.",
        icon: "success",
        type: 'info',
        timer: '1500'
      });
    }
  });
}



function inactive_gymer(url, dataTable){
  var token = $('meta[name="csrf-token"]').attr('content');
  swal({
    title: 'Are you sure?',
    text: 'This Gymer Record and it`s details will be permanantly Inactive!',
    icon: 'warning',
    buttons: ["Cancel", "Yes!"],
    dangerMode: true,
    closeOnClickOutside: false,
  }).then(function(value) {
    if(value == true){
      $.ajax({
        url: url,
        type: "POST",
        data: {
          _token: token,
          '_method': 'DELETE',
        },
        success: function (data) {
          swal({
            title: "Success!",
            type: "success",
            text: data.message+"",
            icon: "success",
            timer: 3000,
            buttons: false,
            showConfirmButton: false,
          }).then(
            window.setTimeout(function(){
              dataTable.ajax.reload();
            } ,3000),
          );
          if (data.message.length == 2) {
            toastr.success(data.message[1]);
            toastr.error(data.message[0]);
          }
        },
        error: function (data) {
          swal({
            title: 'Opps...',
            text: data.message+"\n Please refresh your page",
            type: 'error',
            timer: '1500'
          });
        }
      });
    }else{
      swal({
        title: 'Cancel',
        text: "",
        icon: "success",
        type: 'info',
        timer: '1500'
      });
    }
  });
}

function active_gymer(url, dataTable){
  var token = $('meta[name="csrf-token"]').attr('content');
  swal({
    title: 'Are you sure?',
    text: 'Do you want to Acivate Gymer',
    icon: 'warning',
    buttons: ["Cancel", "Yes!"],
    dangerMode: true,
    closeOnClickOutside: false,
  }).then(function(value) {
    if(value == true){
      $.ajax({
        url: url,
        type: "POST",
        data: {
          _token: token,
          '_method': 'DELETE',
        },
        success: function (data) {
          swal({
            title: "Success!",
            type: "success",
            text: data.message+"",
            icon: "success",
            timer: 3000,
            buttons: false,
            showConfirmButton: false,
          }).then(
            window.setTimeout(function(){
              dataTable.ajax.reload();
            } ,3000),
          );
          if (data.message.length == 2) {
            toastr.success(data.message[1]);
            toastr.error(data.message[0]);
          }
        },
        error: function (data) {
          swal({
            title: 'Opps...',
            text: data.message+"\n Please refresh your page",
            type: 'error',
            timer: '1500'
          });
        }
      });
    }else{
      swal({
        title: 'Cancel',
        text: "",
        icon: "success",
        type: 'info',
        timer: '1500'
      });
    }
  });
}

function delete_gymer(url, dataTable){
  var token = $('meta[name="csrf-token"]').attr('content');
  swal({
    title: 'Are you sure?',
    text: 'Do you want to Delete Gymer',
    icon: 'warning',
    buttons: ["Cancel", "Yes!"],
    dangerMode: true,
    closeOnClickOutside: false,
  }).then(function(value) {
    if(value == true){
      $.ajax({
        url: url,
        type: "POST",
        data: {
          _token: token,
          '_method': 'DELETE',
        },
        success: function (data) {
          swal({
            title: "Success!",
            type: "success",
            text: data.message+"",
            icon: "success",
            timer: 3000,
            buttons: false,
            showConfirmButton: false,
          }).then(
            window.setTimeout(function(){
              dataTable.ajax.reload();
            } ,3000),
          );
          if (data.message.length == 2) {
            toastr.success(data.message[1]);
            toastr.error(data.message[0]);
          }
        },
        error: function (data) {
          swal({
            title: 'Opps...',
            text: data.message+"\n Please refresh your page",
            type: 'error',
            timer: '1500'
          });
        }
      });
    }else{
      swal({
        title: 'Cancel',
        text: "",
        icon: "success",
        type: 'info',
        timer: '1500'
      });
    }
  });
}

function delete_trainer(url, dataTable){
  var token = $('meta[name="csrf-token"]').attr('content');
  swal({
    title: 'Are you sure?',
    text: 'Do you want to Delete Trainer',
    icon: 'warning',
    buttons: ["Cancel", "Yes!"],
    dangerMode: true,
    closeOnClickOutside: false,
  }).then(function(value) {
    if(value == true){
      $.ajax({
        url: url,
        type: "POST",
        data: {
          _token: token,
          '_method': 'DELETE',
        },
        success: function (data) {
          swal({
            title: "Success!",
            type: "success",
            text: data.message+"",
            icon: "success",
            timer: 3000,
            buttons: false,
            showConfirmButton: false,
          }).then(
            window.setTimeout(function(){
              dataTable.ajax.reload();
            } ,3000),
          );
          if (data.message.length == 2) {
            toastr.success(data.message[1]);
            toastr.error(data.message[0]);
          }
        },
        error: function (data) {
          swal({
            title: 'Opps...',
            text: data.message+"\n Please refresh your page",
            type: 'error',
            timer: '1500'
          });
        }
      });
    }else{
      swal({
        title: 'Cancel',
        text: "",
        icon: "success",
        type: 'info',
        timer: '1500'
      });
    }
  });
}


