<div class="modal fade " id="paymentalert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mldal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment Alert </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @foreach ($payments_alert as $alert )
        <div class="card">
                <div class="card-body">
                  <?php
                    $value = $alert->initial_advance;
                  ?>
                  <label for="" class=" "> Name :</label> <label class="mr-3 ">{{ $alert->name }}</label>
                  <label class="text-danger float-right ml-2">{{ abs($value)}}</label><label for="" class="fs-3 ml-5 float-right" >Dues : </label> <br>
                  <label for="" class=" "> Phone :</label> <strong class="mr-3 ">{{ $alert->getUserdetail->phone }}</Strong>
                 <strong class="mr-3 float-right">{{ $alert->getshift->shift_name }} ({{ $alert->getshift->starttime }} - {{ $alert->getshift->endtime }})</Strong> <label for="" class="float-right mr-3"> Shift :</label>
                </div>
        </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
