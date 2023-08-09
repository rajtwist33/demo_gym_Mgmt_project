<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Previous Amount <small class="text-danger">(Before  2023/july)</small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.payment_history.addoldpayment')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Amount</label>
                        <input type="number" name="amount" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  min="0" oninput="this.value = Math.abs(this.value)">
                        <small id="emailHelp" class="form-text text-success">Enter the Previous amounts.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Advance (If any)</label>
                        <input type="number" name="advance" class="form-control" id="exampleInputPassword1"  min="0" oninput="this.value = Math.abs(this.value)">
                        <small id="emailHelp" class="form-text text-info">Enter the Previous advance if any.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Dues (If any)</label>
                        <input type="number" name="dues" class="form-control" id="exampleInputPassword1"  min="0" oninput="this.value = Math.abs(this.value)">
                        <small id="emailHelp" class="form-text text-red">Enter the Previous Dues if any.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Short Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">  </textarea>

                    </div>
                    <input type="hidden" name="user_id" value="{{$user_id->user_id}}">
                    <input type="hidden" name="shift_id" value="{{$user_id->shift_id}}">

                     <input type="hidden" readonly  oninput="this.value = Math.abs(this.value)"  class="form-control" name="backup_advance" id="amount"  value="{{$data}}" oninput="display(this)" autocomplete="off"  >

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
